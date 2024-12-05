<?php

namespace App\Services;

use App\Models\ChiTietPhong; 
use Illuminate\Support\Facades\Log;

class ChiTietPhongService {
    public function getByMaPhong($id) {
        return ChiTietPhong::where('MaPhong', $id)->get(); 
    }

    public function getById($id) {
        return ChiTietPhong::with(['phongTro', 'tienNghi'])->findOrFail($id);
    }

    public function update($request, $id, $maTienNghi) 
    {
        try {
            Log::info('Update request:', [
                'maPhong' => $id,
                'maTienNghi' => $maTienNghi,
                'data' => $request->all()
            ]);
            $result = ChiTietPhong::where('MaPhong', $id)
            ->where('MaTienNghi', $maTienNghi)
            ->update([
                'SoLuong' => $request->SoLuong,
                'TinhTrang' => $request->TinhTrang,
                'GhiChu' => $request->GhiChu,
            ]);

            Log::info('Update result:', ['success' => $result]);
            return $result;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($maPhong, $maTienNghi) {
        try{
            return ChiTietPhong::where('MaPhong', $maPhong)
            ->where('MaTienNghi', $maTienNghi)
            ->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        } 
    }
}