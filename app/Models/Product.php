<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Product extends Model
{
    use HasFactory;
    use HasTimestamps;
    protected $table = 'product';
    protected $primaryKey = 'id';
    
    protected $fillable = ['menu_id', 'user_id', 'alamat_id', 'jumlah_beli', 'created_at', 'tanggal_datang', 'total_harga', 'status', 'notifikasi', 'unread', 'is_new'];

    public function login()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'menu_id', 'id');
    }

    public function alamat()
    {
        return $this->belongsTo(DataAkun::class, 'alamat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id'); // Sesuaikan dengan nama kolom yang sesuai
    }

}