<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PhongTro;
use App\Models\HopDongThue;

class HoaDon extends Model
{
    use HasFactory;
    protected $table = 'hoadon';
    protected $primaryKey = 'MaHoaDon';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaHoaDon','MaPhong','NgayLap','TongTien','TrangThai'];
    public function hopdongthue()
    {
        return $this->belongsTo(HopDongThue::class, 'MaHopDong', 'MaHopDong');
    }
    public function phong()
    {
        return $this->belongsTo(PhongTro::class, 'MaPhong', 'MaPhong');
    }
    public function chitiethoadon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaHoaDon', 'MaHoaDon');
    }
}