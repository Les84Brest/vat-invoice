<?php

namespace App\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Represents an Invoice Type.
 */
class InvoiceDocumentsList implements \Stringable, Jsonable, Arrayable
{

    protected array $invoiceDocuments;


    public function __construct(array $invoiceDocuments)
    {

        $this->setDocuments($invoiceDocuments);
    }

    public function setDocuments(array $invoiceDocuments)
    {
        $invoices = [];
        for ($i = 0; $i < count($invoiceDocuments); $i++) {
            $invoices[] = InvoiceDocument::fromArray($invoiceDocuments[$i]);
        }

        $this->invoiceDocuments = $invoices;
    }

    public function toArray(): array
    {
        if (!count($this->invoiceDocuments)) {
            return [];
        }

        $invoices = [];

        foreach ($this->invoiceDocuments as $document) {
            $invoices[] = $document->toArray();
        }

        return $invoices;
    }

    public function toJson($options = 0)
    {
        if (!count($this->invoiceDocuments)) {
            return '';
        }

        return json_encode($this->toArray());
    }

    /**
     * Returns the string representation of the invoice status.
     *
     * @return string The current status of the invoice.
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
