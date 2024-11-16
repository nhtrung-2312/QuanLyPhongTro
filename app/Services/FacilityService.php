<?php

namespace App\Services;

use App\Models\Facility;

class FacilityService
{
    public function getAll()
    {
        return Facility::orderBy('MaCoSo', 'ASC')->paginate(10);
    }

    // public function rooms(){
    //     return $this->hasMany(Room::class, 'MaCoSo', 'MaCoSo');
    // }
}
