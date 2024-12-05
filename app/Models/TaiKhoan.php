<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaiKhoan extends Model
{
    use HasFactory;
    protected $table = 'TaiKhoan';
    protected $primaryKey = 'MaTaiKhoan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['MaTaiKhoan', 'TenDangNhap', 'MatKhau', 'VaiTro', 'TrangThai'];
    public function phanQuyen()
    {
        return $this->hasMany(PhanQuyen::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
    public function nhanVien()
    {
        return $this->hasOne(NhanVien::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
    public function khachThue()
    {
        return $this->hasOne(KhachThue::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
}
