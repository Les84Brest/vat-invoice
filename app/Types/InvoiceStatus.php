<?php

namespace App\Types;

/**
 * Class InvoiceStatus
 *
 * Represents the status of an invoice and provides methods to validate and manage the status.
 *
 * @package App\Types
 */
class InvoiceStatus implements \Stringable
{
    /** @var string Invoice status is in progress. */
    // В разработке
    const IN_PROGRESS = 'IN_PROGRESS';

    /** @var string Invoice status is in progress but encountered an error. */
    // В разработке с ошибкой
    const IN_PROGRESS_ERROR = 'IN_PROGRESS_ERROR';

    /** @var string Invoice status is completed. */
    // Выставлен
    const COMPLETED = 'COMPLETED';
    
    /** @var string Invoice status is on agreement. */
    // На согласовании
    const ON_AGREEMENT = 'ON_AGREEMENT';

    /** @var string Invoice status is completed and signed. */
    // Выставлен. Подписан получателем
    const COMPLETED_SIGNED = 'COMPLETED_SIGNED';

    /** @var string Invoice status is cancelled. */
    // Аннулирован
    const CANCELLED = 'CANCELLED';

    /** @var string Invoice status is on agreement for cancellation. */
    //Выставлен. Аннулирован поставщиком
    const ON_AGREEMENT_CANCEL = 'ON_AGREEMENT_CANCEL';

    /** @var string The current status of the invoice. */
    private $invoiceStatus = '';

    /**
     * InvoiceStatus constructor.
     *
     * @param string $invoiceStatus The initial status of the invoice.
     * @throws \Exception If the provided status is not valid.
     */
    public function __construct(string $invoiceStatus)
    {
        $this->setStatus($invoiceStatus);
    }

    /**
     * Validates if the given status is a valid invoice status.
     *
     * @param string $type The status to validate.
     * @return bool Returns true if the status is valid, false otherwise.
     */
    public static function validateStatus(string $type): bool
    {
        $validationStatus = match ($type) {
            self::IN_PROGRESS => true,
            self::IN_PROGRESS_ERROR => true,
            self::COMPLETED => true,
            self::ON_AGREEMENT => true,
            self::COMPLETED_SIGNED => true,
            self::CANCELLED => true,
            self::ON_AGREEMENT_CANCEL => true,
            default => false,
        };

        return $validationStatus;
    }

    /**
     * Gets the current status of the invoice.
     *
     * @return string The current status of the invoice.
     */
    public function getStatus(): string
    {
        return $this->invoiceStatus;
    }

    /**
     * Sets the status of the invoice.
     *
     * @param string $invoiceStatus The status to set.
     * @throws \Exception If the provided status is not valid.
     */
    public function setStatus(string $invoiceStatus): void
    {
        if (!self::validateStatus($invoiceStatus)) {
            throw new \Exception('Not correct invoice status value');
        }

        $this->invoiceStatus = $invoiceStatus;
    }

    /**
     * Returns the string representation of the invoice status.
     *
     * @return string The current status of the invoice.
     */
    public function __toString(): string
    {
        return $this->getStatus();
    }
}
