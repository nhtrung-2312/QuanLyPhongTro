<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiPhong;
use App\Models\PhongTro;

class PhongController extends Controller
{
    public function index()
    {
        $loaiphong = LoaiPhong::all();
        return view('Client.Phong.index', compact('loaiphong'));
    }
    public function show($id)
    {

        $phong = PhongTro::with('coSo')->where('MaLoaiPhong', $id)->paginate(6);
        $loaiphong = LoaiPhong::find($id);

        return view('Client.Phong.show', compact('phong', 'loaiphong'));
    }
    public function details($id)
    {
        $phong = PhongTro::with('coSo', 'chiTietPhong', 'loaiPhong')->find($id);
        return view('Client.Phong.details', compact('phong'));
    }
}
