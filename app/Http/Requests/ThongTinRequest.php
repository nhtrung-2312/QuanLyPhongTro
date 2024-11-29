<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThongTinRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'hoten' => 'required|string|max:100',
            'cccd' => 'required|regex:/^[0-9]{12}$/',
            'sdt' => 'required|regex:/^0[0-9]{9}$/',
            'diachi' => 'required|string|max:200',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|in:Nam,Nữ'
        ];
    }
    public function messages()
    {
        return [
            'hoten.required' => 'Vui lòng nhập họ tên',
            'hoten.string' => 'Họ tên không hợp lệ',
            'hoten.max' => 'Họ tên không được vượt quá 255 ký tự',
            'cccd.required' => 'Vui lòng nhập CMND/CCCD',
            'cccd.regex' => 'CCCD phải có đúng 12 số',
            'sdt.required' => 'Vui lòng nhập số điện thoại',
            'sdt.regex' => 'Số điện thoại không hợp lệ',
            'diachi.required' => 'Vui lòng nhập địa chỉ',
            'diachi.string' => 'Địa chỉ không hợp lệ',
            'diachi.max' => 'Địa chỉ không được vượt quá 200 ký tự',
            'ngaysinh.required' => 'Vui lòng nhập ngày sinh',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ',
            'gioitinh.required' => 'Vui lòng chọn giới tính',
            'gioitinh.in' => 'Giới tính không hợp lệ'
        ];
    }
}
