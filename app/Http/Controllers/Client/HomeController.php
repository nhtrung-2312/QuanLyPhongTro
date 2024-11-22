<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('Client.Home.index');
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
