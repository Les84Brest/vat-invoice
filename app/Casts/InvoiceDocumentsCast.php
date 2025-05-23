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
        $castedDocuments = new InvoiceDocumentsList($value);

        return $castedDocuments->toJson();
    }
}
