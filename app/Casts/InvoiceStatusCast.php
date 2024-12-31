<?php

namespace App\Casts;

use App\Types\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class InvoiceStatusCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new InvoiceStatus($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!is_string($value) && !InvoiceStatus::validateStatus($value)) {
            throw new \InvalidArgumentException($key . ' value must be string compatible with allowed invoice statuces');
        }

        return $value;
    }
}
