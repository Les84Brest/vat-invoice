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
    const SENDER_COMPANY_FILTER = 'sender_company';
    const AUTHOR_FILTER = 'author';
    const RECIPIENT_COMPANY_FILTER = 'recipient_company';
    const SIGNATORY_FILTER = 'signatory';

    /**
     * Get the filter callbacks.
     *
     * @return array
     */
    public function getCallbacks(): array
    {
        return [
            self::SENDER_COMPANY_FILTER => [$this, 'sender_company'],
            self::AUTHOR_FILTER => [$this, 'author'],
            self::RECIPIENT_COMPANY_FILTER => [$this, 'recipient_company'],
            self::SIGNATORY_FILTER => [$this, 'signatory'],

        ];
    }

    /**
     * Filter by sender company.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function sender_company(Builder $builder, $value): void
    {
    
        $builder->whereIn('sender_company', $value);
    }

    /**
     * Filter by author.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function author(Builder $builder, $value): void
    {
        $builder->where('author', $value);
    }

    /**
     * Filter by recipient company.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function recipient_company(Builder $builder, $value): void
    {
        $builder->whereIn('recipient_company', $value);
    }

    /**
     * Filter by signatory.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return void
     */
    public function signatory(Builder $builder, $value): void
    {
        $builder->where('signatory', $value);
    }
}