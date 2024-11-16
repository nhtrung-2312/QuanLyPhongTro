<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FacilityService;
use App\Http\Requests\FacilityRequest;

class FacilityController extends Controller
{
    protected $facilityService;

    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    public function index()
    {
        $facilities = $this->facilityService->getAll();
        return view('Admin.Facility.index', compact('facilities'));
    }

    // public function create()
    // {
    //     return view('Admin.Facility.create');
    // }

    // public function update($id)
    // {
    //     return view('Admin.Facility.update', compact('id'));
    // }

    // public function delete($id)
    // {
    //     return view('Admin.Facility.delete', compact('id'));
    // }
}
