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
                        | <a href="{{ url('profile/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                    @endif
                @endif
            </h5>
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('storage/'.$user->avatar) }}" width="100px" class="profile-picture"><br>
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
