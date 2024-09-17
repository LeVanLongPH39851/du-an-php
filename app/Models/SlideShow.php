<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SlideShow extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'slide_shows';

    protected $fillable = [
    'ma_slide_show',
    'ten_slide_show',
    'arrows',
    'dots',
    'infinite',
    'speed',
    'active',
    'deleted_at'
];
    public $timestamps = false;

    public function albumAnhSlideShow()
    {
        return $this->hasMany(SlideShow::class, 'slide_show_id');
    }
}