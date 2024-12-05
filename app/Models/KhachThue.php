<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class KhachThue extends Model
{
    use HasFactory;
    protected $table = 'khachthue';
    protected $primaryKey = 'MaKhachThue';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaKhachThue',
        'HoTen',
        'CCCD',
        'SDT',
        'DiaChi',
        'NgaySinh',
        'GioiTinh',
        'MaTaiKhoan',
    ];

    public function taiKhoan()  
    {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
    public function chitiethopdong()
    {
        return $this->hasMany(ChiTietHopDong::class, 'MaKhachThue', 'MaKhachThue');
    }
}
