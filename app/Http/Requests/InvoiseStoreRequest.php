<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiseStoreRequest extends FormRequest
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
            'number' => '',
            'creation_date' => 'required|date|date_format:Y-m-d',
            'action_date' => 'required|date|date_format:Y-m-d',
            'type' => 'string',
            'status' => 'string',
            'parent_invoice' => '',

            'total' => 'numeric',
            'total_wo_vat' => 'numeric',
            'total_vat' => 'numeric',

            'sender_company' => 'required|numeric|exists:companies,id',
            'author' => 'required|numeric|exists:users,id',

            'recipient_company' => 'nullable|numeric',
            'signatory' => 'nullable|numeric',

            'contract_number' => '',
            'contract_date' => 'nullable|date|date_format:Y-m-d',
            'delivery_documents' => '',
        ];
    }

    public function messages()
{
    return [
        'author.exists' => 'Пользователь не существует',
    ];
}
}
