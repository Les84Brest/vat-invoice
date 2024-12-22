<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO authorization login here
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
            'title' => 'required|string',
            'short_title' => 'required|string',
            'address' => 'nullable|string',
            'tax_id' => 'required|numeric|digits:9|unique:companies,tax_id',
            'users' => 'nullable|array',
            'users.*' => 'numeric'
        ];
    }
}
