<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    use HasFactory;
    protected $table = 'postingan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'nama_menu', 'harga', 'deskripsi', 'image', 'jumlah_pesan', 'jenis', 'kapasitas'];

    public function products()
    {
        return $this->hasMany(Product::class, 'menu_id', 'id');
    }

    // Postingan.php
    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'menu_id', 'id');
    }

}