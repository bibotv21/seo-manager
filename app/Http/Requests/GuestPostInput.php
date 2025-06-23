<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestPostInput extends FormRequest
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
            'target_domain' => 'required',
            'impl_date' => 'required',
            'amount' => 'required',
            'source_link' => 'required',
            'post_link' => 'required',
            'ctv_id' => 'required',
            'domain_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'target_domain.required' => 'Vui lòng nhập tên miền',
            'impl_date.required' => 'Vui lòng nhập ngày đặt',
            'amount.required' => 'Vui lòng nhập giá',
            'source_link.required' => 'Vui lòng nhập link nguồn',
            'post_link.required' => 'Vui lòng nhập link bài đăng',
            'ctv_id.required' => 'Vui lòng chọn CTV',
            'domain_id.required' => 'Vui lòng chọn tên miền',
        ];
    }
}
