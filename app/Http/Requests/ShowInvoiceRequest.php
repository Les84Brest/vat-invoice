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
            'sender_company' => 'nullable|array',
            'sender_company.*' => 'nullable|numeric',
            'author' => 'nullable|numeric',
            'recipient_company' => 'nullable|numeric',
            'signatory' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'page' => 'nullable|numeric',
        ];
    }
}
