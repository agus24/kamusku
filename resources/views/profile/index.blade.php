@extends('layouts.app')
@section('style')
<style>
    .profile-picture {
        border-radius: 50px;
    }
</style>
@endsection

@section('content')
<div class="row">
<div class="col-md-12">
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                Profile
                @if(!Auth::guest())
                    @if(Auth::user()->id == $user->id)
                        | <a href="{{ url('profile/'.$user->id.'/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                        @if(Auth::user()->status == 0)
                            | <a href="{{ url('kirimUlang') }}" class="btn btn-warning btn-sm">Kirim Aktivasi ulang</a>
                        @endif
                    @elseif(Auth::user()->id != $user->id && Auth::user()->status == 1)
                        @php
                            $statusFollow = 1;
                            $statusFollow = App\User::find(Auth::user()->id)->hasFollowUser($user->id);
                        @endphp
                        | <a href="{{ url(($statusFollow ? "unfollow" : "follow")."/".$user->id) }}" class="btn btn-{{ $statusFollow ? "danger" : "success" }} btn-sm">{{ $statusFollow ? "Unfollow" : "Follow" }}</a>
                    @endif
                @endif
            </h5>
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('storage/'.$user->avatar) }}" onerror="this.src='{{ asset('storage/no-image.png') }}'" width="100px" class="profile-picture"><br>
                    <b>{{ $user->name }}</b>
                </div>
                <div class="col-md-10">
                    <p>{!! $user->about_me !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
