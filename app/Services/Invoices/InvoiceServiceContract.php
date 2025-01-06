<?php

namespace App\Services\Invoices;

use Illuminate\Support\Collection;

interface InvoiceServiceContract
{
    public function getInvoices(array $data);
}
