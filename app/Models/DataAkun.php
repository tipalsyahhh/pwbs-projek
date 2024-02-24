<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAkun extends Model
{
    use HasFactory;

    protected $table = 'profile';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_depan', 'nama_belakang', 'tanggal_lahir', 'alamat', 'gender', 'user_id', 'biodata'];
    public $timestamps = false;

    public function user()
    {
    return $this->belongsTo(Login::class, 'user_id', 'id');
    }
}
