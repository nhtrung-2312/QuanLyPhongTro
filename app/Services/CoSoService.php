<?php

namespace App\Services;

use App\Models\CoSo;
use Illuminate\Support\Facades\Log;

class CoSoService
{
    public function getAll()
    {
        return CoSo::orderBy('MaCoSo', 'ASC')->paginate(10);
    }

    public function getById($id){
        return CoSo::findOrFail($id);
    }

    public function generateMaCoSo(){
        $lastCoSo = CoSo::orderBy('MaCoSo', 'DESC')->first();
        if(!$lastCoSo){
            return 'CS001';
        }
        $lastId = (int)substr($lastCoSo->MaCoSo, 2);
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
            $coSo = $this->getById($id);
            $data = [
                'TenCoSo' => $request->TenCoSo,
                'DiaChi' => $request->DiaChi
            ];
            return $coSo->update($data);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            $coSo = $this->getById($id);
            return $coSo->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    // public function rooms(){
    //     return $this->hasMany(Room::class, 'MaCoSo', 'MaCoSo');
    // }
}
