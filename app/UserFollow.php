<?php

namespace App;

use App\UserFollow;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $table = "user_follow";
    protected $primaryKey = "id";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function follow()
    {
        return $this->belongsTo(User::class, 'follow', 'id');
    }
}
