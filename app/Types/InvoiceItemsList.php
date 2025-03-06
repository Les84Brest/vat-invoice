<?php

namespace App\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Represents an Invoice Type.
 */
class InvoiceItemsList implements \Stringable, Jsonable, Arrayable
{

    /** @var InvoiceItem[] */
    protected array $invoiceItems = [];


    public function __construct(string $invoiceItems)
    {

        $this->setDocuments($invoiceItems);
    }
    
    /**
     * Set invoice items ensuring they are of type InvoiceItem
     *
     * @param string $invoiceItems
     */
    public function setDocuments(string $invoiceItems): void
    {
        $jsonItems = json_decode($invoiceItems, true);

        $invoices = [];
        for ($i = 0; $i < count($jsonItems); $i++) {
            $invoices[] = InvoiceDocument::fromArray($jsonItems[$i]);
        }

        $this->invoiceItems = $invoices;
    }

    public function toArray(): array
    {
        if (!count($this->invoiceItems)) {
            return [];
        }

        $invoices = [];

        foreach ($this->invoiceItems as $document) {
            $invoices[] = $document->toArray();
        }

        return $invoices;
    }

    public function toJson($options = 0)
    {
        if (!count($this->invoiceItems)) {
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
