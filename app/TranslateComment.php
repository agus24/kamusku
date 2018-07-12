<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TranslateComment extends Model
{
    protected $table = "translate_comments";
    protected $primaryKey = "id";
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public static function instance()
    {
        return new static;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getComment($translate_id)
    {
        return $this->with('user')->where('translate_id', $translate_id)->get();
    }
}
