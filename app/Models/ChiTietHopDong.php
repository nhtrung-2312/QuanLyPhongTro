<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChiTietHopDong extends Model
{
    use HasFactory;
    protected $table = 'chitiethopdong';
    protected $primaryKey = 'MaHopDong';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['MaHopDong', 'MaKhachThue'];
    public function hopdongthue()
    {
        return $this->belongsTo(HopDongThue::class, 'MaHopDong', 'MaHopDong');
    }
    public function khachthue()
    {
        return $this->belongsTo(KhachThue::class, 'MaKhachThue', 'MaKhachThue');
    }
}
