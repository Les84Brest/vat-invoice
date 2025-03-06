<?php

namespace App\Types;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class InvoiceItem implements \Stringable, Jsonable, Arrayable
{

    protected $id;
    protected $name;
    protected $dimension;
    protected $count;
    protected $price;
    protected $cost;
    protected $vat_rate;
    protected $vat_sum;
    protected $cost_vat;

    public function __construct(
        $id,
        $name,
        $dimension,
        $count,
        $price,
        $cost,
        $vat_rate,
        $vat_sum,
        $cost_vat
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->dimension = $dimension;
        $this->count = $count;
        $this->price = $price;
        $this->cost = $cost;
        $this->vat_rate = $vat_rate;
        $this->vat_sum = $vat_sum;
        $this->cost_vat = $cost_vat;
    }

    public static function fromArray(array $data)
    {
        return new InvoiceItem(
            $data['id'],
            $data['name'],
            $data['dimension'],
            $data['count'],
            $data['price'],
            $data['cost'],
            $data['vat_rate'],
            $data['vat_sum'],
            $data['cost_vat']
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dimension' => $this->dimension,
            'count' => $this->count,
            'price' => $this->price,
            'cost' => $this->cost,
            'vat_rate' => $this->vat_rate,
            'vat_sum' => $this->vat_sum,
            'cost_va' => $this->cost_vat
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
