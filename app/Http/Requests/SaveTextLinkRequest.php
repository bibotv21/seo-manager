<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTextLinkRequest extends FormRequest
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
            'expired_date' => 'required',
            'anchor_text' => 'required',
            'amount' => 'required',
            'ctv_id' => 'required',
            'domain_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'target_domain.required' => "Bạn chưa nhập trang",
            'impl_date.required' => "Bạn chưa chọn ngày đặt",
            'expired_date.required' => "Bạn chưa chọn ngày kết thúc",
            'anchor_text.required' => "Bạn chưa nhập anchor text",
            'amount_date.required' => "Bạn chưa nhập giá tiền",
            'ctv_id.required' => 'Bạn chưa chọn CTV',
            'domain_id.required' => 'Bạn chưa chọn website',
            
        ];
    }
}
