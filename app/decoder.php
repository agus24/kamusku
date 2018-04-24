<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class decoder extends Model
{
    protected $table = "datakata";
    protected $primaryKey = "_id";
    protected $fillable = ["katakunci", "artikata", "output"];
    public $timestamps = false;
}
