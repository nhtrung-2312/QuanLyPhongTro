<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FacilityService;
use App\Http\Requests\FacilityRequest;
use Illuminate\Support\Facades\Log;

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

    public function create()
    {
        return view('Admin.Facility.create');
    }

    public function store(FacilityRequest $request){
        try{
            $result = $this->facilityService->create($request);
            if($result){
            return redirect()->route('admin.facilities.index')->with('success', 'Thêm mới thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id){
        $facility = $this->facilityService->getById($id);
        return view('Admin.Facility.edit', compact('facility'));
    }

    public function update(FacilityRequest $request, $id){
        try {
            $result = $this->facilityService->update($request, $id);
            if($result) {
                return redirect()->route('admin.facilities.index')
                    ->with('success', 'Chỉnh sửa thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function delete($id){
        try {
            $result = $this->facilityService->delete($id);
            if($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xoá thành công!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra!'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra!'
            ]);
        }
    }
}
