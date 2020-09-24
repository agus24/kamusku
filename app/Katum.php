<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Katum extends Model
{
    protected $table = 'kata';
    protected $primaryKey = 'id';
    protected $fillable = ['kata', 'bahasa_id', 'contoh_kalimat'];

    public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'bahasa_id', 'id');
    }

    public function getTranslate()
    {
        return $this->hasMany(Translate::class, 'dari', 'id');
    }

    public function jumlahTranslate()
    {
        return \DB::table('translate')->where('dari', $this->id)->orWhere('tujuan', $this->id)->count();
    }
}
