<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiPhi;

use App\Http\Requests\LoaiPhiRequest;

class LoaiPhiController extends Controller
{
    public function index()
    {
        $loaiPhis = LoaiPhi::all();
        return view('Admin.LoaiPhi.index', compact('loaiPhis'));
    }
    public function create()
    {
        return view('Admin.LoaiPhi.create');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'TenLoaiPhi' => 'required|string|max:255',
                'DonGia' => 'required|numeric|min:0',
            ]);

            $loaiphi = LoaiPhi::findOrFail($id);
            $loaiphi->update([
                'TenLoaiPhi' => $request->TenLoaiPhi,
                'DonGia' => $request->DonGia,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật'
            ], 500);
        }
    }
    public function delete($id)
    {
        $loaiPhi = LoaiPhi::find($id);
        $loaiPhi->delete();
        return redirect()->route('admin.loaiphi.index')->with('success', 'Loại phí đã được xóa thành công');
    }
    public function store(LoaiPhiRequest $request)
    {
        LoaiPhi::create($request->all());
        return redirect()->route('admin.loaiphi.index')->with('success', 'Loại phí đã được tạo thành công');
    }

    public function edit($id)
    {
        try {
            $loaiphi = LoaiPhi::findOrFail($id);
            return response()->json($loaiphi);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy loại phí'
            ], 404);
        }
    }
}
