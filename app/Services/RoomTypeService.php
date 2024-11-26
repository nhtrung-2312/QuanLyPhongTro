<?php

namespace App\Services;
use App\Models\RoomType;
use Illuminate\Support\Facades\Log;

class RoomTypeService
{
    public function getAll()
    {
        return RoomType::orderBy('MaLoaiPhong', 'ASC')->paginate(10);
    }

    public function getById($id){
        return RoomType::findOrFail($id);
    }

    public function generateMaLoaiPhong(){
        $lastRoomType = RoomType::orderBy('MaLoaiPhong', 'DESC')->first();
        if(!$lastRoomType){
            return 'LP001';
        }
        $lastId = (int)substr($lastRoomType->MaLoaiPhong, 2);
        $newId = $lastId + 1;
        return 'LP' . str_pad($newId, 3, '0', STR_PAD_LEFT);
    }

    public function create($request)
    {
        try {
            $data = $request->validated();
            $data['MaLoaiPhong'] = $this->generateMaLoaiPhong();

            Log::info('Data being created:', $data);

            RoomType::create($data);
            return true;
        } catch (\Exception $e) {
            Log::error('Error creating room type: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update($request, $id){
        try{
            $roomType = $this->getById($id);
            $data = [
                'TenLoaiPhong' => $request->TenLoaiPhong,
                'DienTich' => $request->DienTich,
                'SoNguoi' => $request->SoNguoi
            ];
            return $roomType->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;   
        }
    }

    public function delete($id){
        try{
            $roomType = $this->getById($id);
            return $roomType->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }
}
