<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Login;

class ProfileImage extends Model
{
    use HasFactory;

    protected $table = 'profile_images';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'image_path'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }
}