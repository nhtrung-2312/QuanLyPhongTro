<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\HoaDon;

class ChiTietHoaDon extends Model
{
    use HasFactory;
    protected $table = 'chitiethoadon';
    protected $primaryKey = 'MaHoaDon';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaHoaDon','MaLoaiPhi','SoLuong','DonGia','ThanhTien'];
    public function hoadon()
    {
        return $this->belongsTo(HoaDon::class, 'MaHoaDon', 'MaHoaDon');
    }
    public function LoaiPhi()
    {
        return $this->belongsTo(LoaiPhi::class, 'MaLoaiPhi', 'MaLoaiPhi');
    }   
}