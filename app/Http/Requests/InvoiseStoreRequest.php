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

            'sender_company_id' => 'required|numeric|exists:companies,id',
            'author_id' => 'required|numeric|exists:users,id',

            'recipient_company_id' => 'nullable|numeric',
            'signatory_id' => 'nullable|numeric',

            'contract_number' => '',
            'contract_date' => 'nullable|date|date_format:Y-m-d',
            //delivery documents validation
            'delivery_documents' => 'sometimes|array',
            'delivery_document.*.id' => ['required', 'uuid'], 
            //items validation
            'invoice_items' => 'required|array|min:1',

            'invoice_items.*.id' => ['required', 'uuid'], 
            'invoice_items.*.name' => ['required', 'string', 'max:255'],
            'invoice_items.*.dimension' => ['required', 'string', 'max:50'],
            'invoice_items.*.count' => ['required', 'numeric'], 
            'invoice_items.*.price' => ['required', 'numeric', 'min:0'],
            'invoice_items.*.cost' => ['required', 'numeric', 'min:0'],
            'invoice_items.*.vat_rate' => ['required', 'numeric', 'between:0,1'], 
            'invoice_items.*.vat_sum' => ['required', 'numeric', 'min:0'],
            'invoice_items.*.cost_vat' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
{
    return [
        'author.exists' => 'Пользователь не существует',
        'invoice_items.required' => 'Должен быть заполнен раздел \"Данные по товарам (работам, услугам), имущественным правам\"',
        'invoice_items.min' => 'Должен быть заполнен раздел \"Данные по товарам (работам, услугам), имущественным правам\"',
        'invoice_items.*.name.required' => 'Товар (работа, услуга) должны иметь название',
        'invoice_items.*.price.numeric' => 'Цена должна иметь цифровое значение',
        'invoice_items.*.id.uuid' => 'Каждая позиция должна иметь UUID.',
    ];
}
}
