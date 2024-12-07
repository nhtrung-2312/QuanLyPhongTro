<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoadon';
    protected $primaryKey = 'MaHoaDon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'MaHoaDon',
        'MaHopDong',
        'NgayLap',
        'TongTien',
        'TrangThai'
    ];

    public function hopdongthue()
    {
        return $this->belongsTo(HopDongThue::class, 'MaHopDong', 'MaHopDong');
    }

    public function chiTietHoaDon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaHoaDon', 'MaHoaDon');
    }

    public function chisodiennuoc()
    {
        return $this->belongsTo(ChiSoDienNuoc::class, 'MaChiSo', 'MaChiSo');
    }

    public static function capNhatTongTien($maHoaDon)
    {
        $hoadon = self::with(['hopdongthue.phong', 'chiTietHoaDon'])
            ->find($maHoaDon);

        if ($hoadon) {
            $tienPhong = $hoadon->hopdongthue->phong->GiaThue;
            $tongTienDichVu = $hoadon->chiTietHoaDon->sum('ThanhTien');
            $tongCong = $tienPhong + $tongTienDichVu;

            $hoadon->TongTien = $tongCong;
            $hoadon->save();

            return $tongCong;
        }

        return 0;
    }

    public function khachthue()
    {
        return $this->belongsTo(KhachThue::class, 'MaKhachThue', 'MaKhachThue');
    }
}
