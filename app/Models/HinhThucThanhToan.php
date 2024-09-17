<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HinhThucThanhToan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'phuong_thuc_thanh_toans';

    protected $fillable = [
    'ma_phuong_thuc_thanh_toan',
    'ten_phuong_thuc_thanh_toan',
    'deleted_at'
];
    public $timestamps = false;

    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'phuong_thuc_thanh_toan_id');
    }
}