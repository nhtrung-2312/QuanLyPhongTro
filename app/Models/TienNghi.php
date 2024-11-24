<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TienNghi extends Model
{
    use HasFactory;
    protected $table = 'TienNghi';
    protected $primaryKey = 'MaTienNghi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'MaTienNghi',
        'TenTienNghi',
        'MoTa',
    ];
    public function chiTietPhong()
    {
        return $this->hasMany(ChiTietPhong::class, 'MaTienNghi', 'MaTienNghi');
    }
}
