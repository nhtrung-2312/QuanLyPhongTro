<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class KhachThue extends Model
{
    use HasFactory;
    protected $table = 'KhachThue';
    protected $primaryKey = 'MaKhachThue';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['MaKhachThue', 'HoTen', 'CCCD', 'SDT', 'DiaChi', 'NgaySinh', 'GioiTinh', 'MaTaiKhoan'];
}
