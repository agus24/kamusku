<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bahasa;
use App\Translate;

class Katum extends Model
{
    protected $table = "kata";
    protected $primaryKey = "id";

    public function bahasa() {
        return $this->belongsTo(Bahasa::class, 'bahasa_id', 'id');
    }

    public function getTranslate()
    {
        return $this->hasMany(Translate::class, "dari", "id");
    }
}
