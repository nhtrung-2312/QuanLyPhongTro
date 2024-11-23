<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoaiPhong extends Model
{
    use HasFactory;
    protected $table = 'LoaiPhong';
    protected $primaryKey = 'MaLoaiPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaLoaiPhong',
        'DienTich',
        'LoaiPhong',
        'SoNguoi',
    ];
}
