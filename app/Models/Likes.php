<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Likes extends Model
{
    use HasFactory;
    use HasTimestamps;
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'comentar', 'like', 'created_at', 'status_id', 'notifikasi'];

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public static function addLike($user_id, $status_id)
    {
        return Likes::create([
            'user_id' => $user_id,
            'status_id' => $status_id,
            'like' => 1,
        ]);
    }

    public static function addComment($user_id)
    {
        return Likes::create([
            'user_id' => $user_id,
            'comentar' => 1,
        ]);
    }

    public static function waktuComment($user_id, $commentText)
    {
        return Likes::create([
            'user_id' => $user_id,
            'comentar' => $commentText,
            'created_at' => now(), // Tambahkan created_at di sini
        ]);
    }

    public function getStatusUserId()
    {
        // Menggunakan relasi status() untuk mendapatkan objek status
        $status = $this->status;

        // Mengambil user_id dari objek status
        $statusUserId = $status->user_id;

        return $statusUserId;
    }
}