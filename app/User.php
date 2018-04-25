<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasFollowBahasa($id)
    {
        return DB::table('bahasa_follows')->where('user_id', $this->id)
                ->where("bahasa_id", $id)->count() > 0;
    }

    public function follow($id)
    {
        $ins = DB::table("bahasa_follows")->insert([
            "user_id" => $this->id,
            "bahasa_id" => $id
        ]);

        return ($ins) ? true : false;
    }

    public function unfollow($id)
    {
        $del = DB::table('bahasa_follows')->where('user_id', $this->id)
                ->where("bahasa_id", $id)->delete();

        return ($del) ? true : false;
    }
}
