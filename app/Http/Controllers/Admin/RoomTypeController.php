<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoomTypeService;
use App\Http\Requests\RoomTypeRequest;
use Illuminate\Support\Facades\Log;

class RoomTypeController extends Controller
{
    protected $roomTypeService;

    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }
    public function index()
    {
        $roomTypes = $this->roomTypeService->getAll();
        return view('Admin.RoomType.index', compact('roomTypes'));
    }
    public function create()
    {
        return view('Admin.RoomType.create');
    }
    public function store(RoomTypeRequest $request)
    {
        try{
            $result = $this->roomTypeService->create($request);
            if($result){
                return redirect()->route('admin.room-types.index')->with('success', 'Thêm mới thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!' . $e->getMessage());
        }
    }

    public function edit($id){
        $roomType = $this->roomTypeService->getById($id);
        return view('Admin.RoomType.edit', compact('roomType'));
    }

    public function update(RoomTypeRequest $request, $id){
        try {
            $result = $this->roomTypeService->update($request, $id);
            if($result) {
                return redirect()->route('admin.room-types.index')
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
            $result = $this->roomTypeService->delete($id);
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
