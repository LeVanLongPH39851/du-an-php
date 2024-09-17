<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrangThaiDonHang extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'trang_thai_don_hangs';
    protected $fillable = [
    'ma_trang_thai_don_hang',
    'ten_trang_thai_don_hang',
    'deleted_at'
];
    public $timestamps = false;

    public function donHang()
    {
        return $this->hasMany(DanhMuc::class, 'trang_thai_don_hang_id');
    }
}