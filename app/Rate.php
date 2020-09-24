<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'translate_rates';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function translate()
    {
        return $this->belongsTo(Translate::class, 'translate_id', 'id');
    }
}
