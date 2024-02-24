<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataToko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_depan', 'nama_belakang', 'alamat', 'email', 'user_id', 'detail'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function myPostingan()
    {
        return $this->hasMany(Login::class, 'user_id', 'id');
    }
}
