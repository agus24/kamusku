<?php

namespace App;

use App\User;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function getFollowers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'following', 'user_id');
    }

    public function getFollowing()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'following');
    }

    public function translate()
    {
        return $this->hasMany(Translate::class, 'user_id', 'id');
    }

    public function hasFollowUser($user_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }

        return DB::table('user_follow')->where('user_id', $id)->where('following', $user_id)->get()->count() > 0;
    }

    public function followUser($user_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }

        $user_follow = new UserFollow;
        $user_follow->user_id = $id;
        $user_follow->following = $user_id;
        if($user_follow->save()) {
            return true;
        } else {
            abort(504);
        }
    }

    public function unfollowUser($user_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }

        $user_follow = new UserFollow;
        if($user_follow->where('user_id', $id)->where('following', $user_id)->delete()) {
            return true;
        } else {
            abort(504);
        }
    }
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

    public function hasLike($translate_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }
        return DB::table('translate_rates')->where('user_id', $id)->where('translate_id', $translate_id)->get()->count() > 0;
    }

    public function unlikeTranslate($translate_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }

        DB::table('translate_rates')->where('user_id', $id)->where('translate_id', $translate_id)->delete();
        DB::table('translate')->where('id', $translate_id)->decrement('rate');
    }

    public function likeTranslate($translate_id, $id = false)
    {
        if(!$id) {
            $id = $this->id;
        }

        DB::table('translate_rates')->where('user_id', $id)->where('translate_id', $translate_id)->insert([
            "translate_id" => $translate_id,
            "user_id" => $id
        ]);
        DB::table('translate')->where('id', $translate_id)->increment('rate');
    }
}
