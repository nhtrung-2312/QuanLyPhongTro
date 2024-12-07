<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhanQuyen extends Model
{
    use HasFactory;
    protected $table = 'phanquyen';
    protected $primaryKey = ['MaTaiKhoan', 'MaQuyen', 'MaCoSo'];
    protected $fillable = ['MaTaiKhoan', 'MaQuyen', 'MaCoSo'];
    public $incrementing = false;
    public $timestamps = false;
    public function taikhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'MaTaiKhoan', 'MaTaiKhoan');
    }
    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'MaQuyen', 'MaQuyen');
    }
    public function coSo()
    {
        return $this->belongsTo(CoSo::class, 'MaCoSo', 'MaCoSo');
    }
}
