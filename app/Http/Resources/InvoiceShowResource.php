<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceShowResource extends JsonResource
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
            'number' => $this->number,
            'creation_date' => Carbon::createFromFormat('Y-m-d', $this->creation_date)->format('d.m.Y'),
            'action_date' => Carbon::createFromFormat('Y-m-d', $this->action_date)->format('d.m.Y'),
            'type' => $this->type,
            'status' => $this->status,

            'total' => $this->total,
            'total_wo_vat' => $this->total_wo_vat,
            'total_vat' => $this->total_vat,

            'author' => new UserLightResource($this->author),
            
            'recipient_company' => new CompanyShowResource($this->recipient_company),
            'sender_company' => new CompanyShowResource($this->sender_company),
        ];
    }
}
