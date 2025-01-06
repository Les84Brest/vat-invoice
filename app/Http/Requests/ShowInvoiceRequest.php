<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender_company_id' => 'nullable|array',
            'sender_company_id.*' => 'nullable|numeric',
            'author_id' => 'nullable|numeric',
            'recipient_company_id' => 'nullable|array',
            'recipient_company_id.*' => 'nullable|numeric',
            'signatory_id' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'page' => 'nullable|numeric',
        ];
    }
}
