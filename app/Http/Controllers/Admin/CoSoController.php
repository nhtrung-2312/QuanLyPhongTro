<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CoSoService;
use App\Http\Requests\CoSoRequest;
use Illuminate\Support\Facades\Log;

class CoSoController extends Controller
{
    protected $coSoService;

    public function __construct(CoSoService $coSoService)
    {
        $this->coSoService = $coSoService;
    }

    public function index()
    {
        $coSos = $this->coSoService->getAll();
        return view('Admin.CoSo.index', compact('coSos'));
    }

    public function create()
    {
        return view('Admin.CoSo.create');
    }

    public function store(CoSoRequest $request){
        try{
            $result = $this->coSoService->create($request);
            if($result){
            return redirect()->route('admin.coSos.index')->with('success', 'Thêm mới thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function edit($id){
        $coSo = $this->coSoService->getById($id);
        return view('Admin.CoSo.edit', compact('coSo'));
    }

    public function update(CoSoRequest $request, $id){
        try {
            $result = $this->coSoService->update($request, $id);
            if($result) {
                return redirect()->route('admin.coSos.index')
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
            $result = $this->coSoService->delete($id);
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
