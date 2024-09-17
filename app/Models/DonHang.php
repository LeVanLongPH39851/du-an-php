<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonHang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'don_hangs';

    protected $fillable = [
    'ma_don_hang',
    'user_id',
    'ten_nguoi_nhan',
    'email_nguoi_nhan',
    'so_dien_thoai_nguoi_nhan',
    'dia_chi_nguoi_nhan',
    'ngay_dat',
    'tong_tien',
    'ghi_chu',
    'phuong_thuc_thanh_toan_id',
    'trang_thai_don_hang_id',
    'deleted_at'
];
    public $timestamps = false;

    public function chiTietDonHang()
    {
        return $this->hasMany(DonHang::class, 'don_hang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}