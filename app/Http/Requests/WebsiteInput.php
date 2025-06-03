<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebsiteInput extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('domains')->ignore($this->wb_id)
            ],
            'amount' => 'required',
            'purchase_date' => 'required',
            'expired_date' => 'required',
            'provider' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên domain',
            'amount.required' => 'Bạn chưa nhập giá',
            'purchase_date.required' => 'Bạn chưa nhập ngày mua domain',
            'provider.required' => 'Bạn chưa nhập nơi mua domain',
            'name.unique' => 'Domain ' . $this->input('name') .' đã tồn tại'
        ];
    }
}
