<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;
    protected $table = "bai_viets";
    protected $fillable = [
        'ma_bai_viet',
        'tieu_de',
        'anh_bai_viet',
        'noi_dung',
        'ngay_dang',
        'user_id',
        'san_pham_id'
    ];
    public $timestamps = false;
}