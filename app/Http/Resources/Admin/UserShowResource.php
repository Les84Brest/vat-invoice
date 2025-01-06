<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\CompanyShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource
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
            'email' => $this->email,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'role' => $this->role,
            'company' => new CompanyShowResource($this->whenLoaded('company')),
        ];
    }
}
