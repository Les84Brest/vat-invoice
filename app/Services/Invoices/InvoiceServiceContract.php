<?php

namespace App\Services\Invoices;

interface InvoiceServiceContract
{
    public function getInvoices(array $data);
    public function createInvoice(array $data);
    public function createAndSubmit(array $data);
}
