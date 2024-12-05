<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChiTietPhongRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        $rules = [
            'MaPhong' => 'required|exists:phongtro,MaPhong',
            'MaTienNghi' => 'required|exists:tiennghi,MaTienNghi',
            'SoLuong' => 'required|integer|min:1',
            'TinhTrang' => 'required|string|max:255',
            'GhiChu' => 'nullable|string|max:500'
        ];

        if ($this->isMethod('post')) {
            // Create operation
            $rules['MaPhong'] = [
                'required',
                Rule::unique('chitietphong', 'MaPhong')
                    ->where(function ($query) {
                        return $query->where('MaTienNghi', $this->MaTienNghi);
                    })
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'MaPhong.unique' => 'Phòng đã có tiện nghi này',
            'MaPhong.required' => 'Vui lòng chọn phòng',
            'MaPhong.exists' => 'Phòng không tồn tại',
            'MaTienNghi.required' => 'Vui lòng chọn tiện nghi',
            'MaTienNghi.exists' => 'Tiện nghi không tồn tại',
            'SoLuong.required' => 'Vui lòng nhập số lượng',
            'SoLuong.integer' => 'Số lượng phải là số nguyên',
            'SoLuong.min' => 'Số lượng tối thiểu là 1',
            'TinhTrang.required' => 'Vui lòng nhập tình trạng',
            'TinhTrang.max' => 'Tình trạng không quá 255 ký tự',
            'GhiChu.max' => 'Ghi chú không quá 500 ký tự'
        ];
    }
}