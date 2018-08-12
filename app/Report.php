<?php

namespace App;

use App\Translate;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = "reports";
    protected $primaryKey = "id";

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", 'id');
    }

    public function translate()
    {
        return $this->belongsTo(Translate::class, "translate_id", 'id');
    }
}
