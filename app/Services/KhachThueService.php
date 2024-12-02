<?php

namespace App\Services;

use App\Models\KhachThue;
use Illuminate\Support\Facades\Log;

class KhachThueService
{   
    public function getAll($filters = [])
    {
        $query = KhachThue::with('taiKhoan')->orderBy('MaKhachThue', 'ASC');
        if (isset($filters['MaTaiKhoan'])) {
            $query->where('MaTaiKhoan', $filters['MaTaiKhoan']);
        }   
        return $query->paginate(5);
    }
}