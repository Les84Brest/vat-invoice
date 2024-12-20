<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use App\Structures\CompanyTransactionStatus as CompanyTransactionStatusStructure;

class CompanyTransactionStatus implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return CompanyTransactionStatusStructure::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!is_string($value) && !$value instanceof CompanyTransactionStatusStructure) {
            throw new \InvalidArgumentException($key . 'value must be instance of CompanyTransactionStatus or JSON string');
        }

        if (is_string($value)) return $value;

        return $value->toJson();
    }
}
