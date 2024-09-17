<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_gio_hangs';
    protected $fillable = [
        'ma_chi_tiet_gio_hang',
        'gio_hang_id',
        'san_pham_id',
        'bien_the_san_pham_id',
        'so_luong',
    ];
    public $timestamps = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function bienTheSanPham()
    {
        return $this->belongsTo(BienTheSanPham::class, 'bien_the_san_pham_id');
    }

    public function gioHang()
    {
        return $this->belongsTo(DanhMuc::class, 'gio_hang_id');
    }
}