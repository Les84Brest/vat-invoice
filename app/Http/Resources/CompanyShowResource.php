<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_title' => $this->short_title,
            'address' => $this->address,
            'tax_id' => $this->tax_id,
            'last_invoice_number' => $this->last_invoice_number,
        ];
    }
}
