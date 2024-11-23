<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PhongTro extends Model
{
    use HasFactory;
    protected $table = 'phongtro';
    protected $primaryKey = 'MaPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaPhong',
        'MaCoSo',
        'MaLoaiPhong',
        'TenPhong',
        'GiaThue',
        'TrangThai',
        'MoTa',
    ];
    public function coSo()
    {
        return $this->belongsTo(CoSo::class, 'MaCoSo', 'MaCoSo');
    }
}
