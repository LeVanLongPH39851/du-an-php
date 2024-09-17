<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DanhMuc extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'danh_mucs';
    protected $fillable = [
        'ma_danh_muc',
        'ten_danh_muc',
        'anh_danh_muc',
        'danh_muc_cha_id',
        'ngay_nhap',
        'deleted_at'
    ];
    public $timestamps = false;

    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'san_pham_id');
    }
    public function children()
    {
        return $this->hasMany(DanhMuc::class, 'danh_muc_cha_id');
    }

    public function parent()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_cha_id');
    }
}