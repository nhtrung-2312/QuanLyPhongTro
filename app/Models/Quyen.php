<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Quyen extends Model
{
    use HasFactory;
    protected $table = 'quyen';
    protected $primaryKey = 'MaQuyen';
    protected $fillable = ['MaQuyen', 'TenQuyen', 'MoTa'];
    public $timestamps = false;
    public $incrementing = false;
    public function phanQuyen()
    {
        return $this->hasMany(PhanQuyen::class, 'MaQuyen', 'MaQuyen');
    }
}
