<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiPhi;
use App\Http\Requests\LoaiPhiRequest;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
class LoaiPhiController extends Controller
{
    public function index()
    {
        $selectedFacility = session('selected_facility');
        $loaiPhis = LoaiPhi::where('MaCoSo', $selectedFacility)->get();
        return view('Admin.LoaiPhi.index', compact('loaiPhis'));
    }
    public function create()
    {
        return view('Admin.LoaiPhi.create');
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->validate([
            'DonGia' => 'required|numeric|min:0',
        ], [
            'DonGia.required' => 'Vui lòng nhập đơn giá',
            'DonGia.numeric' => 'Đơn giá phải là số',
            'DonGia.min' => 'Đơn giá phải lớn hơn 0',
        ]);
        $loaiPhi = LoaiPhi::find($id);
        $loaiPhi->update($credentials);
        return response()->json(['success' => true, 'data' => $loaiPhi]);
    }
    public function delete($id)
    {
        $loaiPhi = LoaiPhi::find($id);
        $exist = ChiTietHoaDon::where('MaLoaiPhi', $id)->exists();
        if($exist) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa loại phí này vì đã được sử dụng trong hóa đơn'
            ]);
        }
        $loaiPhi->delete();
        return response()->json(['success' => true, 'data' => $loaiPhi]);
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'TenLoaiPhi' => 'required|string|max:255',
            'DonGia' => 'required|numeric|min:0',
        ], [
            'TenLoaiPhi.required' => 'Vui lòng nhập tên loại phí',
            'DonGia.required' => 'Vui lòng nhập đơn giá',
            'DonGia.numeric' => 'Đơn giá phải là số',
            'DonGia.min' => 'Đơn giá phải lớn hơn 0',
        ]);

        do {
            $maLoaiPhi = 'PHI' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (LoaiPhi::where('MaLoaiPhi', $maLoaiPhi)->exists());

        $lp = new LoaiPhi();
        $lp->MaLoaiPhi = $maLoaiPhi;
        $lp->MaCoSo = session('selected_facility');
        $lp->TenLoaiPhi = $request->TenLoaiPhi;
        $lp->DonGia = $request->DonGia;
        $lp->save();

        return response()->json(['success' => true, 'data' => $lp]);
    }

    public function edit($id)
    {
        $loaiPhi = LoaiPhi::find($id);
        return response()->json(['success' => true, 'data' => $loaiPhi]);
    }

}
