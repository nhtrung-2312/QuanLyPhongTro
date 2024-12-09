<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TienNghi;
use App\Model\ChiTietPhong;

class TienNghiController extends Controller
{
    public function index()
    {
        $tiennghi = TienNghi::all();
        return view('admin.tiennghi.index', compact('tiennghi'));
    }
    public function create()
    {
        return view('admin.tiennghi.create');
    }
    public function update(Request $request)
    {
        $request->validate([
            'TenTienNghi' => 'required|string|max:50',
        ], [
            'TenTienNghi.required' => 'Tên tiện nghi không được để trống',
            'TenTienNghi.max' => 'Tên tiện nghi không được quá 50 ký tự',
        ]);
        $tiennghi = TienNghi::find($request->MaTienNghi);
        $tiennghi->TenTienNghi = $request->TenTienNghi;
        $tiennghi->MoTa = $request->MoTa;
        $tiennghi->save();
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
    public function edit($id)
    {
        $tiennghi = TienNghi::find($id);
        return response()->json(['data' => $tiennghi]);
    }
    public function delete(Request $request)
    {
        try {
            TienNghi::find($request->MaTienNghi)->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Kiểm tra lại dữ liệu trước khi xoá!']);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'TenTienNghi' => 'required|string|max:50',
            'MoTa' => 'nullable|string|max:255',
        ], [
            'TenTienNghi.required' => 'Tên tiện nghi không được để trống',
            'TenTienNghi.max' => 'Tên tiện nghi không được quá 50 ký tự',
            'MoTa.max' => 'Mô tả không được quá 255 ký tự',
        ]);

        do {
            $MaTienNghi = 'TN' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (TienNghi::where('MaTienNghi', $MaTienNghi)->exists());

        $existingTienNghi = TienNghi::where('TenTienNghi', $request->TenTienNghi)->first();
        if ($existingTienNghi) {
            return response()->json(['success' => false, 'message' => 'Tên tiện nghi đã tồn tại']);
        }

        $request['MaTienNghi'] = $MaTienNghi;
        TienNghi::create($request->all());
        return response()->json(['success' => true, 'message' => 'Thêm tiện nghi thành công']);
    }
}

