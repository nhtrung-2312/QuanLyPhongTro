<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        $rules = [
            'TenCoSo' => 'required|string|max:100',
            'DiaChi' => 'required|string|max:200'
        ];
        return $rules;
    }

    public function messages(){
        return [
            'TenCoSo.required' => 'Tên cơ sở không được để trống',
            'DiaChi.required' => 'Địa chỉ không được để trống',
        ];
    }
}
