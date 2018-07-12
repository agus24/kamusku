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
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id != $id || Auth::guest())
        {
            abort(404);
        }

        $user = User::find($id);
        return view('profile.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "nama" => "required",
            "password" => "required|same:password_confirmation",
            "password_confirmation" => "required"
        ]);
        $user = User::find($id);

        if($request->file('img')) {
            $file = $request->file('img');
            $file->move(storage_path('app/public/users/edit/'), date("Ymd")."_".$file->getClientOriginalName());
            $user->avatar = "users\\edit\\".date("Ymd")."_".$file->getClientOriginalName();
        }

        $user->name = $request->nama;
        $user->password = bcrypt($request->password);
        $user->about_me = $request->about_me;
        $user->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
