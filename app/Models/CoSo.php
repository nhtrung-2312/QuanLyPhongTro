<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoSo extends Model
{
    use HasFactory;
    protected $table = 'CoSo';
    protected $primaryKey = 'MaCoSo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaCoSo',
        'TenCoSo',
        'DiaChi',
    ];
    public function phongTro()
    {
        return $this->hasMany(PhongTro::class, 'MaCoSo', 'MaCoSo');
    }
    public function hoadon()
    {
        return $this->hasManyThrough(
            HoaDon::class,
            PhongTro::class,
            'MaCoSo', // Khóa ngoại trên bảng phongtro
            'MaPhong', // Khóa ngoại trên bảng hoadon
            'MaCoSo', // Khóa chính của bảng coso
            'MaPhong'  // Khóa chính của bảng phongtro
        );
    }
}
