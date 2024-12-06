<?php

namespace App\Services;

use App\Models\PhongTro;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PhongService{
    public function getAllWithCoSo($maCoSo, $filters = []) {
        $query = PhongTro::with(['coSo', 'loaiPhong'])
                ->where('MaCoSo', $maCoSo)
                ->orderBy('MaPhong', 'ASC');
        if (!empty($filters['MaLoaiPhong'])) {
            $query->where('MaLoaiPhong', $filters['MaLoaiPhong']);
        }
        if (!empty($filters['TrangThai'])) {
            $query->where('TrangThai', $filters['TrangThai']);
        }
        return $query->paginate(10);
    }
    public function getAll($filters = [])
    {
        $query = PhongTro::with(['coSo', 'loaiPhong'])->orderBy('MaPhong', 'ASC');
        if (!empty($filters['MaCoSo'])) {
            $query->where('MaCoSo', $filters['MaCoSo']);
        }

        if (!empty($filters['MaLoaiPhong'])) {
            $query->where('MaLoaiPhong', $filters['MaLoaiPhong']);
        }

        if (!empty($filters['TrangThai'])) {
            $query->where('TrangThai', $filters['TrangThai']);
        }
        return $query->paginate(10);
    }

    public function getById($id){
        return PhongTro::with(['coSo', 'loaiPhong'])->findOrFail($id);
    }

    public function generateMaPhong(){
        $lastRoom = PhongTro::orderBy('MaPhong', 'DESC')->first();
        if(!$lastRoom){
            return 'P001';
        }
        $lastId = (int)substr($lastRoom->MaPhong, 2);
        $newId = $lastId + 1;
        return 'P' . str_pad($newId, 3, '0', STR_PAD_LEFT);
    }

    protected function getImagePath($maPhong)
    {
        // Check common image extensions
        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
        foreach ($extensions as $ext) {
            $path = "public/template/client/dist/img/phong/{$maPhong}.{$ext}";
            if (Storage::exists($path)) {
                return $path;
            }
        }
        return null;
    }

    public function create($request)
    {
        try {
            $data = $request->validated();
            $data['MaPhong'] = $this->generateMaPhong();

            Log::info('Inserting Data: ', $data);


            $phong = PhongTro::create($data);
            if ($request->hasFile('HinhAnh')) {
                $image = $request->file('HinhAnh');
                $extension = $image->getClientOriginalExtension();
                $imageName = $phong->MaPhong . '.' . $extension;
                $image->move(public_path('template/client/dist/img/phong'), $imageName);
            }

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update($request, $id){
        try{
            $phong = $this->getById($id);
            $data = [
                'TenPhong' => $request->TenPhong,
                'GiaThue' => $request->GiaThue,
                'TrangThai' => $request->TrangThai,
                'MoTa' => $request->MoTa
            ];
            if ($request->hasFile('HinhAnh')) {
                // Remove old image if exists
                $oldImage = public_path("template/client/dist/img/phong/{$phong->MaPhong}.*");
                array_map('unlink', glob($oldImage));

                // Save new image
                $image = $request->file('HinhAnh');
                $extension = $image->getClientOriginalExtension();
                $imageName = $phong->MaPhong . '.' . $extension;
                $image->move(public_path('template/client/dist/img/phong'), $imageName);
            }

            $result = $phong->update($data);


            return $result;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            $room = $this->getById($id);
            return $room->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }
}
