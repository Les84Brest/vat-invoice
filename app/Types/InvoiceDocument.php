<?php

namespace App\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class InvoiceDocument implements \Stringable, Jsonable, Arrayable
{

    protected $id;
    protected $document_type;
    protected $number;
    protected $date;

    public function __construct(
        string $id,
        string $document_type,
        string $number,
        string $date
    ) {
        $this->id = $id;
        $this->document_type = $document_type;
        $this->number = $number;
        $this->date = $date;
    }

    public static function fromArray(array $data)
    {
        return new InvoiceDocument(
            $data['id'],
            $data['document_type'],
            $data['number'],
            $data['date'],

        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'document_type' => $this->document_type,
            'number' => $this->number,
            'date' => $this->date,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }


    public function __toString(): string
    {
        return $this->toJson();
    }
}
