<?php

namespace App\Services;

use App\Models\CoSo;
use Illuminate\Support\Facades\Log;

class FacilityService
{
    public function getAll()
    {
        return CoSo::orderBy('MaCoSo', 'ASC')->paginate(10);
    }

    public function getById($id){
        return CoSo::findOrFail($id);
    }

    public function generateMaCoSo(){
        $lastFacility = CoSo::orderBy('MaCoSo', 'DESC')->first();
        if(!$lastFacility){
            return 'CS001';
        }
        $lastId = (int)substr($lastFacility->MaCoSo, 2);
        $newId = $lastId + 1;
        return 'CS' . str_pad($newId, 3, '0', STR_PAD_LEFT);
    }

    public function create($request)
    {
        try {
            $data = $request->validated();
            $data['MaCoSo'] = $this->generateMaCoSo();

            CoSo::create($data);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update($request, $id){
        try{
            $facility = $this->getById($id);
            $data = [
                'TenCoSo' => $request->TenCoSo,
                'DiaChi' => $request->DiaChi
            ];
            return $facility->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            $facility = $this->getById($id);
            return $facility->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    // public function rooms(){
    //     return $this->hasMany(Room::class, 'MaCoSo', 'MaCoSo');
    // }
}
