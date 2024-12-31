<?php

namespace App\Types;

/**
 * Represents an Invoice Type.
 */
class InvoiceType implements \Stringable
{
    const ORIGINAL = 'ORIGINAL';
    const CORRECTED = 'CORRECTED';

    protected $invoiceType;

    /**
     * InvoiceType constructor.
     *
     * @param string $invoiceType The type of the invoice.
     */
    public function __construct(string $invoiceType)
    {
        $this->setType($invoiceType);
    }

    /**
     * Validate the invoice status type.
     *
     * @param string $type The type to validate.
     * @return bool True if the type is valid, false otherwise.
     */
    public static function validateStatus(string $type): bool
    {
        $validationStatus = match ($type) {
            self::ORIGINAL => true,
            self::CORRECTED => true,
            default => false,
        };

        return $validationStatus;
    }

    /**
     * Get the invoice type.
     *
     * @return string The type of the invoice.
     */
    public function getType(): string
    {
        return $this->invoiceType;
    }

    /**
     * Set the invoice type.
     *
     * @param string $invoiceType The type of the invoice to set.
     * @throws \Exception When the invoice status value is not correct.
     */
    public function setType(string $invoiceType): void
    {
        if (!self::validateStatus($invoiceType)) {
            throw new \Exception('Not correct invoice status value');
        }

        $this->invoiceType = $invoiceType;
    }

    /**
     * Returns the string representation of the invoice status.
     *
     * @return string The current status of the invoice.
     */
    public function __toString(): string
    {
        return $this->getType();
    }
}
