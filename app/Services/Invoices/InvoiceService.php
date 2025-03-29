<?php

namespace App\Services\Invoices;

use App\Filters\InvoiceFilter;
use App\Models\Company;
use App\Models\Invoice;
use App\Types\InvoiceStatus;
use App\Types\InvoiceType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class InvoiceService implements InvoiceServiceContract
{
    public function getInvoices(array $data)
    {
        if (isset($data['limit'])) {
            $limit = $data['limit'];
            unset($data['limit']);
        } else {
            $limit = 10;
        }

        if (empty($data)) {
            return Invoice::query()->paginate($limit);
        }

        /** @var InvoiceFilter $invoiceFilter */
        $invoiceFilter = app()->make(InvoiceFilter::class, ['queryParams' => array_filter($data)]);

        return Invoice::query()
            ->filter($invoiceFilter)
            ->paginate($limit);
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

    private function incrementCompanyLastInvoiceNumber(string $stringNumber, int $companyId): void
    {
        $parts = explode('-', $stringNumber);
        $firstDigitGroupWithoutZeros = ltrim($parts[0] ?? '', '0');

        $company = Company::findOrFail($companyId);
        $company->last_invoice_number = $firstDigitGroupWithoutZeros;
        $company->save();
    }
}
