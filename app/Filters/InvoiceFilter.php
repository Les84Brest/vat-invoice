<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class InvoiceFilter
 *
 * @package App\Filters
 */
class InvoiceFilter extends AbstractFilter
{
    const SENDER_COMPANY_FILTER = 'sender_company_id';
    const AUTHOR_FILTER = 'author_id';
    const RECIPIENT_COMPANY_FILTER = 'recipient_company_id';
    const SIGNATORY_FILTER = 'signatory_id';
    const STATUS_FILTER = 'status';


    /**
     * Get the filter callbacks.
     *
     * @return array
     */
    public function getCallbacks(): array
    {
        return [
            self::SENDER_COMPANY_FILTER => [$this, 'sender_company_id'],
            self::AUTHOR_FILTER => [$this, 'author_id'],
            self::RECIPIENT_COMPANY_FILTER => [$this, 'recipient_company_id'],
            self::SIGNATORY_FILTER => [$this, 'signatory_id'],
            self::STATUS_FILTER => [$this, 'status'],

        ];
    }
    /**
     * Filter by invoice status.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function status(Builder $builder, $value)
    {
        $builder->whereIn('status', $value);
    }
    /**
     * Filter by sender company.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function sender_company_id(Builder $builder, $value): void
    {

        $builder->whereIn('sender_company_id', $value);
    }

    /**
     * Filter by author.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function author_id(Builder $builder, $value): void
    {
        $builder->where('author_id', $value);
    }

    /**
     * Filter by recipient company.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function recipient_company_id(Builder $builder, $value): void
    {
        $builder->whereIn('recipient_company_id', $value);
    }

    /**
     * Filter by signatory.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function signatory_id(Builder $builder, $value): void
    {
        $builder->where('signatory_id', $value);
    }
}
