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
            'title' => 'nullable|string',
            'short_title' => 'nullable|string',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|numeric|digits:9',
            'users' => 'nullable|array',
            'users.*' => 'nullable|numeric'
        ];
    }
}
