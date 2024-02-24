<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Follow extends Model
{
    use HasFactory;
    use HasTimestamps;

    protected $table = 'follows'; // Nama tabel dalam database
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'user_id', 'following_user_id', 'notifikasi', 'created_at']; // Kolom yang dapat diisi

    protected $dates = ['created_at'];
    
    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function followingUser()
    {
        return $this->belongsTo(Login::class, 'following_user_id', 'id');
    }
    
}