<?php

namespace App\Services\Invoices;

use App\Filters\InvoiceFilter;
use App\Models\Company;
use App\Models\Invoice;
use App\Types\InvoiceStatus;
use App\Types\InvoiceType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InvoiceService implements InvoiceServiceContract
{
    public function getInvoices(array $data)
    {
        $page = $data['page'] ?? null;
        $orderColumn = $data['orderColumn'] ?? null;
        $orderDir = $data['orderDir'] ?? null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
            unset($data['limit']);
        } else {
            $limit = 10;
        }

        unset($data['page'], $data['orderColumn'], $data['orderDir']);

        $filterData = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        if (empty($filterData) && $orderColumn === null && $orderDir === null) {
            return Invoice::query()->paginate($limit);
        }

        /** @var InvoiceFilter $invoiceFilter */
        $invoiceFilter = app()->make(InvoiceFilter::class, ['queryParams' => $filterData]);
        $query = Invoice::query()
            ->filter($invoiceFilter)
            ->with(['sender_company', 'recipient_company', 'author']);

        if ($orderColumn !== null && $orderDir !== null) {
            $this->applySorting($query, $orderColumn, $orderDir);
        }

        if ($page) {
            return $query->paginate($limit, ['*'], 'page', $page);
        }

        return $query->paginate($limit);
    }

    private function applySorting(Builder $query, int|string $orderColumn, string $orderDir): void
    {
        $orderDir = strtolower($orderDir) === 'desc' ? 'desc' : 'asc';
        $column = $this->normalizeOrderColumn($orderColumn);

        if ($column === 'sender_company.title') {
            $query->leftJoin('companies as sender_companies', 'sender_companies.id', '=', 'invoices.sender_company_id')
                ->select('invoices.*')
                ->orderBy('sender_companies.title', $orderDir);

            return;
        }

        if ($column === 'recipient_company.title') {
            $query->leftJoin('companies as recipient_companies', 'recipient_companies.id', '=', 'invoices.recipient_company_id')
                ->select('invoices.*')
                ->orderBy('recipient_companies.title', $orderDir);

            return;
        }

        if ($column === 'author.full_name') {
            $query->leftJoin('users as authors', 'authors.id', '=', 'invoices.author_id')
                ->select('invoices.*')
                ->orderBy('authors.full_name', $orderDir);

            return;
        }

        $query->orderBy($column, $orderDir);
    }

    private function normalizeOrderColumn(int|string $orderColumn): string
    {
        $columnIndex = (int) $orderColumn;

        return match ($columnIndex) {
            0 => 'number',
            1 => 'sender_company.title',
            2 => 'recipient_company.title',
            3 => 'author.full_name',
            4 => 'status',
            5 => 'type',
            6 => 'total_wo_vat',
            7 => 'total_vat',
            8 => 'total',
            default => 'number',
        };
    }

    public function createInvoice(array $data)
    {
        try {
            DB::beginTransaction();

            $invoice = Invoice::create($data);
            $this->incrementCompanyLastInvoiceNumber($data['number'], $data['sender_company_id']);

            DB::commit();
            return $invoice;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function createAndSubmit(array $data)
    {
        // Check if the password check was done
        $passwordCacheId = 'password_confirmed_' . Auth::user()->id;
        if (!Cache::has($passwordCacheId)) {
            return response()->json([
                'message' => 'Неправильный пароль',
                'error' => true,
            ]);
        }

        $data['status'] = InvoiceStatus::COMPLETED;
        $savedInvoice = $this->createInvoice($data);


        return $savedInvoice;
    }

    public function submitInvoice(Invoice $invoice)
    {
        $passwordCacheId = 'password_confirmed_' . Auth::user()->id;

        if (!Cache::has($passwordCacheId)) {
            return response()->json([
                'message' => 'Неправильный пароль',
                'error' => true,
            ]);
        }

        $oldStatus = $invoice->status;

        if ($oldStatus == InvoiceStatus::IN_PROGRESS) {
            $invoice->status = InvoiceStatus::COMPLETED;
        }

        if ($oldStatus == InvoiceStatus::COMPLETED) {
            $invoice->status = InvoiceStatus::COMPLETED_SIGNED;
        }


        $invoice->save();
        // Invoice::where('id', $id)->update(["status" => InvoiceStatus::COMPLETED]);

        // return response()->json([
        //     'message' => 'Счет подписан',
        //     'success' => true,
        // ]);
        return response()->json([
            'message' => 'Все отработало',
            'success' => true,
        ]);
    }

    public function updateInvoice(array $data, Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $invoice->update($data);

            DB::commit();
            return $invoice;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function cancelInvoice(Invoice $invoice)
    {
        try {
            DB::beginTransaction();
            $status = $invoice->status;

            if ($status == InvoiceStatus::COMPLETED) {
                $invoice->status = InvoiceStatus::CANCELLED;
            }

            if ($status == InvoiceStatus::COMPLETED_SIGNED) {
                $invoice->status = InvoiceStatus::ON_AGREEMENT_CANCEL;
            }
            //когда анулируется счет, предварительно подписанным двумя сторонаями
            // аннулировала принимающая сторона
            if ($status == InvoiceStatus::ON_AGREEMENT_CANCEL) {
                $invoice->status = InvoiceStatus::CANCELLED;
            }

            $invoice->save();

            DB::commit();
            return $invoice;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    private function incrementCompanyLastInvoiceNumber(string $stringNumber, int $companyId): void
    {
        $parts = explode('-', $stringNumber);
        $firstDigitGroupWithoutZeros = ltrim($parts[0] ?? '', '0');

        $company = Company::findOrFail($companyId);
        $company->last_invoice_number = $firstDigitGroupWithoutZeros;
        $company->save();
    }
}
