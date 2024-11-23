<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LoaiPhong;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $loaiphong = LoaiPhong::all();

        return view('Client.Home.index', compact('loaiphong'));
    }
    public function about()
    {
        return view('Client.Home.about');
    }
    public function contact()
    {
        return view('Client.Home.contact');
    }
}
