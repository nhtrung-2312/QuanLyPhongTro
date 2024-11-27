<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoaiPhi extends Model
{
    use HasFactory;
    protected $primaryKey = 'MaLoaiPhi';
    protected $table = 'LoaiPhi';
    protected $fillable = ['MaLoaiPhi', 'TenLoaiPhi', 'DonGia'];
    public $timestamps = false;
    public $incrementing = false;
    public function chitiethoadon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaLoaiPhi', 'MaLoaiPhi');
    }
}
