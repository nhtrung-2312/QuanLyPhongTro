<?php

namespace App\Services;

use App\Models\PhongTro;
use Illuminate\Support\Facades\Log;

class PhongService{
    public function getAll($filters = [])
    {
        Log::info('Filters: ', $filters);
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
        return PhongTro::findOrFail($id);
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

    public function create($request)
    {
        try {
            $data = $request->validated();
            $data['MaPhong'] = $this->generateMaPhong();

            Log::info('Inserting Data: ', $data);


            PhongTro::create($data);
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
            return $phong->update($data);
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