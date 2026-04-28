<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use App\Types\InvoiceDocumentsList;
use App\Types\InvoiceDocument;

class InvoiceDocumentsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if(!isset($value)){
            return  new InvoiceDocumentsList([]);
        }
        $docs = json_decode($value, true);
        return  new InvoiceDocumentsList($docs);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // If already an InvoiceDocumentsList instance, just return JSON
        if ($value instanceof InvoiceDocumentsList) {
            return $value->toJson();
        }

        // If it's an array, create a new instance
        if (is_array($value)) {
            $castedDocuments = new InvoiceDocumentsList($value);
            return $castedDocuments->toJson();
        }

        // If it's already a JSON string, return as-is
        return $value;
    }
}

