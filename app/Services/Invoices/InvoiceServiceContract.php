<?php

namespace App\Services\Invoices;

use App\Models\Invoice;

interface InvoiceServiceContract
{
    public function getInvoices(array $data);
    public function createInvoice(array $data);
    public function createAndSubmit(array $data);
    public function submitInvoice(Invoice $invoice);
    public function updateInvoice(array $data,Invoice $invoice );
    public function cancelInvoice(Invoice $invoice);
}
