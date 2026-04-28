<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use App\Types\InvoiceItemsList;

class InvoiceItemsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $castedItems = json_decode($value, true) ?? [];
        return  new InvoiceItemsList($castedItems);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // If already an InvoiceItemsList instance, just return JSON
        if ($value instanceof InvoiceItemsList) {
            return $value->toJson();
        }

        // If it's an array, create a new instance
        if (is_array($value)) {
            $castedItems = new InvoiceItemsList($value);
            return $castedItems->toJson();
        }

        // If it's already a JSON string, return as-is
        return $value;
    }
}
