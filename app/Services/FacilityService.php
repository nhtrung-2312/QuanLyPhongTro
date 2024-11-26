<?php

namespace App\Services;

use App\Models\Facility;
use Illuminate\Support\Facades\Log;

class FacilityService
{
    public function getAll()
    {
        return Facility::orderBy('MaCoSo', 'ASC')->paginate(10);
    }

    public function getById($id){
        return Facility::findOrFail($id);
    }

    public function generateMaCoSo(){
        $lastFacility = Facility::orderBy('MaCoSo', 'DESC')->first();
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

            Facility::create($data);
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
