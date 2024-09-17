<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BinhLuan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'binh_luans';
    protected $fillable = [
        'ma_binh_luan',
        'user_id',
        'san_pham_id',
        'noi_dung',
        'thoi_gian',
        'deleted_at'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chiTietDongHang()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}