<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoaiPhongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'LoaiPhong' => 'required|string|max:100',
            'DienTich' => 'required|numeric|min:0',
            'SoNguoi' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'LoaiPhong.required' => 'Loại phòng không được để trống',
            'DienTich.required' => 'Diện tích không được để trống',
            'SoNguoi.required' => 'Số người không được để trống',
            'DienTich.numeric' => 'Diện tích phải là số',
            'SoNguoi.numeric' => 'Số người phải là số',
            'DienTich.min' => 'Diện tích phải lớn hơn 0',
            'SoNguoi.min' => 'Số người phải lớn hơn 0',
        ];
    }
}
