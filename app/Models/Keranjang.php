<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'menu_id'];

    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'menu_id', 'id');
    }

    // Postingan.php
    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

}