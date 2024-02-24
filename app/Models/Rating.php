<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'menu_id', 'rating', 'comentar', 'image'];

    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'menu_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

}