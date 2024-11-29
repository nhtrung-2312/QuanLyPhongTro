<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoaiPhi;
use Illuminate\Http\Request;

class LoaiPhiController extends Controller
{
    public function index()
    {
        $loaiphis = LoaiPhi::paginate(5);
        return view('admin.LoaiPhi.index', compact('loaiphis'));
    }
}
