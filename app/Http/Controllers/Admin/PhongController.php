<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChiTietPhongRequest;
use Illuminate\Http\Request;
use App\Services\PhongService;
use App\Http\Requests\PhongRequest;
use App\Models\ChiTietPhong;
use App\Models\CoSo;
use App\Models\LoaiPhong;
use App\Models\TienNghi;
use App\Services\ChiTietPhongService;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Log;

class PhongController extends Controller{
    protected $phongService;
    protected $chitietService;

    public function __construct(PhongService $phongService, ChiTietPhongService $chiTietService)
    {
        $this->phongService = $phongService;
        $this->chitietService = $chiTietService;
        
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
        try {
            $phong = $this->phongService->getById($id);
            $cosos = CoSo::all();
            $loaiphongs = LoaiPhong::all();
            return view('Admin.Phong.edit', compact('phong', 'cosos', 'loaiphongs'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }  
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

    public function details($id){
        try{    
            $phong = $this->phongService->getById($id);
            $chiTietPhongs = ChiTietPhong::with('tienNghi')
                        ->where('MaPhong', $id)
                        ->paginate(10);
            return view('Admin.Phong.details', compact('phong', 'chiTietPhongs'));
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function createDetail($id){
        try{
            $phong = $this->phongService->getById($id);
            $tienNghis = TienNghi::all();
            return view('Admin.Phong.createDetail', compact('phong', 'tienNghis'));
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }    
    }
    public function storeDetail(ChiTietPhongRequest $request)
    {
        try {
            $exists = ChiTietPhong::where('MaPhong', $request->MaPhong)
                ->where('MaTienNghi', $request->MaTienNghi)
                ->exists();
                
            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['duplicate' => 'Tiện nghi này đã tồn tại trong phòng']);
            }

            $chiTietPhong = new ChiTietPhong();
            $chiTietPhong->fill($request->validated());
            $chiTietPhong->save();

            return redirect()
                ->route('admin.rooms.details', $request->MaPhong)
                ->with('success', 'Thêm tiện nghi thành công!');
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function editDetail($id, $maTienNghi){
        try {
            $chiTietPhong = ChiTietPhong::where('MaPhong', $id)
                ->where('MaTienNghi', $maTienNghi)
                ->firstOrFail();
            return view('Admin.Phong.editDetail', compact('chiTietPhong'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function updateDetail(ChiTietPhongRequest $request, $id, $maTienNghi)
    {
        try {
            $result = $this->chitietService->update($request, $id, $maTienNghi);
            if($result) {
                return redirect()->route('admin.rooms.details', ['id' => $id, 'maTienNghi' => $maTienNghi]) 
                    ->with('success', 'Chỉnh sửa thành công!');
            }
            return back()->with('error', 'Có lỗi xảy ra!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function deleteDetail($id, $maTienNghi){
        try {
            $result = $this->chitietService->delete($id, $maTienNghi);
            if($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xoá thành công!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tiện nghi!'
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
