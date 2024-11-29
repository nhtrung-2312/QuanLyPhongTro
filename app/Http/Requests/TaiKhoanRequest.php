<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaiKhoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ],
            'repassword' => 'required|same:password'
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải bao gồm 1 chữ cái in hoa, 1 chữ cái thường, 1 số và tối thiểu 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm 1 chữ cái in hoa, 1 chữ cái thường, 1 số và tối thiểu 8 ký tự',
            'repassword.required' => 'Vui lòng nhập lại mật khẩu',
            'repassword.same' => 'Mật khẩu nhập lại không khớp'
        ];
    }
}
