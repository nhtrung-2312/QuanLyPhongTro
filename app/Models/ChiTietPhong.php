<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChiTietPhong extends Model
{
    use HasFactory;
    protected $table = 'ChiTietPhong';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaPhong',
        'MaTienNghi',
        'SoLuong',
        'TinhTrang',
        'GhiChu',
    ];
    public function tienNghi()
    {
        return $this->belongsTo(TienNghi::class, 'MaTienNghi', 'MaTienNghi');
    }
    public function phongTro()
    {
        return $this->belongsTo(PhongTro::class, 'MaPhong', 'MaPhong');
    }
}
