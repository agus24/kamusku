<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $trans = $user->translate()->orderBy('created_at', 'desc')->paginate(5);

        return view('profile.index', compact('user', 'trans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->id != $id || Auth::guest()) {
            abort(404);
        }

        $user = User::find($id);

        return view('profile.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'     => 'required',
            'password' => 'same:password_confirmation',
            // "password_confirmation" => "required"
        ]);

        $user = User::find($id);
        $password = $user->password;
        $forceLogout = false;

        if ($request->file('img')) {
            $file = $request->file('img');
            $file->move(storage_path('app/public/users/edit/'), date('Ymd').'_'.$file->getClientOriginalName());
            $user->avatar = 'users\\edit\\'.date('Ymd').'_'.$file->getClientOriginalName();
        }

        $user->name = $request->nama;
        if ($request->password != '') {
            $user->password = bcrypt($request->password);
            $forceLogout = true;
        } else {
            $user->password = $password;
        }
        $user->about_me = $request->about_me;
        $user->save();
        if ($forceLogout) {
            Auth::logout();
        }

        return redirect('/profile/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function follow($id)
    {
        if (Auth::guest()) {
            abort(404);
        }

        User::find(Auth::user()->id)->followUser($id);

        return redirect()->back();
    }

    public function unfollow($id)
    {
        if (Auth::guest()) {
            abort(404);
        }

        User::find(Auth::user()->id)->unfollowUser($id);

        return redirect()->back();
    }

    public function getFollowingList($user_id)
    {
        $user = User::find($user_id);
        $follow = $user->getFollowing()->orderBy('created_at', 'desc')->get();

        return view('profile.follow', compact('follow', 'user'));
    }

    public function getFollowersList($user_id)
    {
        $user = User::find($user_id);
        $follow = $user->getFollowers()->orderBy('created_at', 'desc')->get();

        return view('profile.follow', compact('follow', 'user'));
    }
}
