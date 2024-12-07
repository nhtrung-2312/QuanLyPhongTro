<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChiSoDienNuoc extends Model
{
    use HasFactory;
    protected $table = 'chisodiennuoc';
    protected $primaryKey = 'MaChiSo';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaChiSo', 'MaPhong', 'DienCu', 'DienMoi', 'NuocCu', 'NuocMoi', 'NgayGhi'];

    public function phong()
    {
        return $this->belongsTo(PhongTro::class, 'MaPhong', 'MaPhong');
    }

    public function hoadon()
    {
        return $this->hasOne(HoaDon::class, 'MaChiSo', 'MaChiSo');
    }
}
