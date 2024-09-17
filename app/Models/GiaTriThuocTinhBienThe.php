<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiaTriThuocTinhBienThe extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'gia_tri_thuoc_tinh_bien_thes';

    protected $fillable = [
    'ma_gia_tri_thuoc_tinh_bt',
    'ten_gia_tri_thuoc_tinh_bt',
    'deleted_at'
];
    public $timestamps = false;

    public function thuocTinhVaGiaTriBienThe()
    {
        return $this->hasMany(ThuocTinhVaGiaTriBienThe::class, 'gia_tri_thuoc_tinh_bien_the_id');
    }
}