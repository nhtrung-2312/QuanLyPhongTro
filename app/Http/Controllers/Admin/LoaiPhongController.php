<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LoaiPhongService;
use App\Http\Requests\LoaiPhongRequest;
use Illuminate\Support\Facades\Log;

class LoaiPhongController extends Controller
{
    protected $loaiPhongService;

    public function __construct(LoaiPhongService $loaiPhongService)
    {
        $this->loaiPhongService = $loaiPhongService;
    }
    public function index()
    {
        $loaiPhongs = $this->loaiPhongService->getAll();
        return view('Admin.LoaiPhong.index', compact('loaiPhongs'));
    }
    public function create()
    {
        return view('Admin.LoaiPhong.create');
    }
    public function store(LoaiPhongRequest $request)
    {
        try{
            $result = $this->loaiPhongService->create($request);
            if($result){
                return redirect()->route('admin.loaiphong.index')->with('success', 'Thêm mới thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!' . $e->getMessage());
        }
    }

    public function edit($id){
        $loaiPhong = $this->loaiPhongService->getById($id);
        return view('Admin.LoaiPhong.edit', compact('loaiPhong'));
    }

    public function update(LoaiPhongRequest $request, $id){
        try {
            $result = $this->loaiPhongService->update($request, $id);
            if($result) {
                return redirect()->route('admin.loaiphong.index')
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
            $result = $this->loaiPhongService->delete($id);
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
