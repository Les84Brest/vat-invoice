<?php

namespace App\Services\Invoices;

use App\Filters\InvoiceFilter;
use App\Models\Invoice;
use Illuminate\Support\Collection;

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
}
