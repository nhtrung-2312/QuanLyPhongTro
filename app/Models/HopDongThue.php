<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class HopDongThue extends Model
{
    use HasFactory;
    protected $table = 'hopdongthue';
    protected $primaryKey = 'MaHopDong';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaHopDong','MaPhong','NgayBatDau','NgayKetThuc','TrangThai','TienCoc'];
    public function hoadon()
    {
        return $this->hasMany(HoaDon::class, 'MaHopDong', 'MaHopDong');
    }
    public function phong()
    {
        return $this->belongsTo(PhongTro::class, 'MaPhong', 'MaPhong');
    }
    public function chitiethopdong()
    {
        return $this->hasMany(ChiTietHopDong::class, 'MaHopDong', 'MaHopDong');
    }
}
