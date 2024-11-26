<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'loaiphong';
    protected $primaryKey = 'MaLoaiPhong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'MaLoaiPhong',
        'LoaiPhong',
        'DienTich',
        'SoNguoi'
    ];

}
