<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;
    protected $table = 'gio_hangs';

    protected $fillable = [
    'ma_gio_hang',
    'user_id'
];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function chiTietGioHang()
    {
        return $this->hasMany(GioHang::class, 'gio_hang_id');
    }
}