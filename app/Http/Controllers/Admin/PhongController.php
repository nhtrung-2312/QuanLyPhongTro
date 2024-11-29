<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PhongService;
use App\Http\Requests\PhongRequest;
use App\Models\CoSo;
use App\Models\LoaiPhong;
use Illuminate\Support\Facades\Log;

class PhongController extends Controller{
    protected $phongService;

    public function __construct(PhongService $phongService)
    {
        $this->phongService = $phongService;
    }

    public function index(Request $request){
        $filters = $request->only(['MaCoSo', 'MaLoaiPhong', 'TrangThai']);

        $phongs = $this->phongService->getAll($filters);
        $cosos = CoSo::all();
        $loaiphongs = LoaiPhong::all();
        
        return view('Admin.Phong.index', compact('phongs', 'cosos', 'loaiphongs'));
    }

    public function create(){
        $cosos = CoSo::all();
        $loaiphongs = LoaiPhong::all();
        return view('Admin.Phong.create', compact('cosos', 'loaiphongs'));
    }

    public function store(PhongRequest $request){
        try{
            $result = $this->phongService->create($request);
            if($result){
            return redirect()->route('admin.rooms.index')->with('success', 'Thêm mới thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id){
        $phongs = $this->phongService->getById($id);
        return view('Admin.Phong.edit', compact('phongs'));
    }

    public function update(PhongRequest $request, $id){
        try {
            $result = $this->phongService->update($request, $id);
            if($result) {
                return redirect()->route('admin.rooms.index')
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
            $result = $this->phongService->delete($id);
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
