<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlbumAnhSlideShow extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'album_anh_slide_shows';
    protected $fillable = [
        'ma_album_anh_slide_show',
        'duong_dan_anh',
        'link',
        'order',
        'slide_show_id',
        'deleted_at'
    ];
    public $timestamps = false;

    public function slideShow()
    {
        return $this->belongsTo(SlideShow::class, 'slide_show_id');
    }
}