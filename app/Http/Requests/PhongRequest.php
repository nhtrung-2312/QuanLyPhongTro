<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules()
    {
        $rules = [
            'TenPhong' => 'required|string|max:255|unique:phongtro,TenPhong,NULL,id,MaCoSo,' . $this->MaCoSo,
            'MaCoSo' => 'exists:coso,MaCoSo', 
            'TenPhong.unique' => 'Tên phòng đã tồn tại trong cơ sở này.',
            'MaLoaiPhong' => 'exists:loaiphong,MaLoaiPhong',
            'GiaThue' => 'required|numeric|min:0', 
            'TrangThai' => 'required|in:Đang thuê,Đang xử lý,Phòng trống', 
            'MoTa' => 'nullable|string|max:500', 
            
        ];
        return $rules;
    }

    
    public function messages()
    {
        return [
            'TenPhong.required' => 'Tên phòng là bắt buộc.',
            'GiaThue.required' => 'Giá thuê là bắt buộc.',
            'TrangThai.required' => 'Trạng thái là bắt buộc.',
            'MoTa.max' => 'Mô tả không được vượt quá 500 ký tự.',
            'GiaThue.numeric' => 'Giá thuê phải là số',
            'GiaThue.min' => 'Giá thuê phải lớn hơn 0',
            // Add more custom messages as needed
        ];
    }
}