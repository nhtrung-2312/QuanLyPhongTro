<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CoSo;
class NhanVien extends Model
{
    use HasFactory;
    protected $table = 'nhanvien';
    public $timestamps = false;
    protected $primaryKey = 'MaNhanVien';
    public $incrementing = false;
    protected $fillable = [
        'MaNhanVien',
        'HoTen',
        'SDT',
        'DiaChi',
        'NgaySinh',
        'GioiTinh',
        'ChucVu',
        'Luong',
        'MaCoSo',
        'MaTaiKhoan',
    ];
    public function coSo()
    {
        return $this->belongsTo(CoSo::class, 'MaCoSo', 'MaCoSo');
    }
    public function taikhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
}
