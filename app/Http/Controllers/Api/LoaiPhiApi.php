<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoaiPhi;

class LoaiPhiApi extends Controller
{
    public function getLoaiPhi() {
        $loaiphis = LoaiPhi::where('MaCoSo', session('selected_facility'))
            ->whereNotIn('TenLoaiPhi', ['Phí khác', 'Tiền điện', 'Tiền nước'])
            ->get();
        return response(['success' => 'true', 'data' => $loaiphis]);
    }
}
