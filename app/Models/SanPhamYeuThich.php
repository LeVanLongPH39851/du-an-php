<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamYeuThich extends Model
{
    use HasFactory;
    protected $table = 'san_pham_yeu_thichs';
    protected $fillable = [
        'user_id',
        'san_pham_id'
    ];
    public $timestamps = false; 
}