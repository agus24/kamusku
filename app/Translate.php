<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Katum as Kata;
use App\User;

class Translate extends Model
{
    protected $table = "translate";

    public function dariKata()
    {
        return $this->belongsTo(Kata::class, 'dari', 'id');
    }

    public function tujuanKata()
    {
        return $this->belongsTo(Kata::class, 'tujuan', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
