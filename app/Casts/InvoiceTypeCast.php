<?php

namespace App\Casts;

use App\Types\InvoiceStatus;
use App\Types\InvoiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class InvoiceTypeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $invoiceType = new InvoiceType($value);
        return $invoiceType->__toString();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!is_string($value) && !InvoiceType::validateStatus($value)) {
            throw new \InvalidArgumentException($key . ' value must be string compatible with allowed invoice types');
        }

        return $value;
    }
}
