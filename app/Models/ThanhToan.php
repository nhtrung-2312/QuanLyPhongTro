<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanhtoan';
    protected $primaryKey = 'MaThanhToan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MaThanhToan',
        'MaHoaDon',
        'NgayThanhToan',
        'SoTien',
        'PhuongThucThanhToan',
        'GhiChu'
    ];

    protected $casts = [
        'NgayThanhToan' => 'datetime',
        'SoTien' => 'float'
    ];

    public function hoadon()
    {
        return $this->belongsTo(HoaDon::class, 'MaHoaDon', 'MaHoaDon');
    }
}