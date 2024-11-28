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
    protected $fillable = ['MaTaiKhoan', 'TenDangNhap', 'VaiTro', 'TrangThai'];
    protected $hidden = ['MatKhau'];
    public function khachThue()
    {
        return $this->hasOne(KhachThue::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
    public function getPassword()
    {
        return $this->MatKhau;
    }
    public function getRole() {
        if($this->VaiTro == "Khách thuê") {
            return 'client';
        }
        return 'admin';
    }
}
