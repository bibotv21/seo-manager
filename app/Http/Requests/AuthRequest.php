<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'user' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => "Bạn chưa nhập user name",
            'password.required' => "Bạn chưa nhập user password"
        ];
    }
}
