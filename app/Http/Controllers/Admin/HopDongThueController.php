<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HopDongThue;

class HopDongThueController extends Controller
{
    public function index()
    {
        $hopdongthues = HopDongThue::paginate(5);
        return view('Admin.HopDongThue.index', compact('hopdongthues'));
    }
}
