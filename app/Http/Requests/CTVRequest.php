<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CTVRequest extends FormRequest
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
            'account_id' => 'required|unique:ctv,account_id'
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'account_id.required' => 'Bạn chưa nhập id của CTV',
            'account_id.unique' => 'CTV ' . $this->input('account_id') . ' đã tồn tại'
        ];
    }
}

