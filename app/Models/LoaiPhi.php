<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiPhi extends Model
{
    protected $table = 'loaiphi';
    protected $primaryKey = 'MaLoaiPhi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'MaLoaiPhi',
        'TenLoaiPhi',
        'DonGia'
    ];

    // Relationship với ChiTietHoaDon
    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaLoaiPhi', 'MaLoaiPhi');
    }
}
