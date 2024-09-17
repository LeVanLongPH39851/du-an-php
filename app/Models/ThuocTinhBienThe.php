<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThuocTinhBienThe extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'thuoc_tinh_bien_thes';

    protected $fillable = [
    'ma_thuoc_tinh_bien_the',
    'ten_thuoc_tinh_bien_the',
    'bien_the_san_pham_id',
    'deleted_at'
];
    public $timestamps = false;
    
    public function thuocTinhVaGiaTriBienThe()
    {
        return $this->hasMany(ThuocTinhVaGiaTriBienThe::class, 'thuoc_tinh_bien_the_id');
    }
}