<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $table = 'friendships';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'friend_id', 'status'];

    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const REJECTED = 'rejected';

    public function user()
    {
        return $this->belongsTo(Login::class, 'user_id', 'id');
    }

    public function friend()
    {
        return $this->belongsTo(Login::class, 'friend_id', 'id');
    }

    public function isPending()
    {
        return $this->status === self::PENDING;
    }

    public function isAccepted()
    {
        return $this->status === self::ACCEPTED;
    }

    public function isRejected()
    {
        return $this->status === self::REJECTED;
    }
}