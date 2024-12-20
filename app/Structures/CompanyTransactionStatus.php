<?php

namespace App\Structures;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class CompanyTransactionStatus implements Jsonable, Arrayable, \Stringable
{
    public $reject_code = 0;
    public $message = '';

    public static function fromArray($data){
        $instance =  new CompanyTransactionStatus();
        $instance->reject_code = $data['reject_code'];
        $instance->message = $data['message'];

        return $instance;
    }

    public function toJson($options = 0)
    {
        return json_encode($this);
    }

    public function __toString()
    {
        return $this->toJson();
    }
    public function toArray()
    {
        return [
            'reject_code' => $this->reject_code,
            'message' => $this->message
        ];
    }
}
