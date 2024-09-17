<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlbumAnh extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'album_anhs';
    protected $fillable = [
        'ma_album_anh',
        'duong_dan_anh',
        'san_pham_id',
        'deleted_at'
    ];

    public $timestamps = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}