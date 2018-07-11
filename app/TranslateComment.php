<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslateComment extends Model
{
    protected $table = "translate_comments";
    protected $primaryKey = "id";

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
