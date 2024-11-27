<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachThue;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = KhachThue::paginate(5);
        return view('admin.customer.index', compact('customers'));
    }
}
