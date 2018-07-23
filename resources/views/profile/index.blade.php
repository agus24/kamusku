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
                <span style="float:right">
                    @if(!Auth::guest())
                        @if(Auth::user()->id == $user->id)
                            <a href="{{ url('profile/'.$user->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            @if(Auth::user()->status == 0)
                                <a href="{{ url('kirimUlang') }}" class="btn btn-warning btn-sm"><i class="fas fa-paper-plane"></i> Kirim Aktivasi ulang</a>
                            @endif
                        @endif
                    @endif
                </span>
            </h5><br>
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('storage/'.$user->avatar) }}" onerror="this.src='{{ asset('storage/no-image.png') }}'" width="100px" class="profile-picture"><br>
                    <b>{{ $user->name }}</b>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @php
                            $post = $user->translate->count() > 10000 ? number_format(floor($user->translate->count()/1000))."k" : $user->translate->count();
                            $following = $user->getFollowing->count() > 10000 ? number_format($user->getFollowing->count()/1000)."k" : $user->getFollowing->count();
                            $followers = $user->getFollowers->count() > 10000 ? number_format($user->getFollowers->count()/1000)."k" : $user->getFollowers->count();
                        @endphp
                        <div class="col-md-4">
                            <p style="font-size:20px;text-align:center;"><b>{{ $post }}</b> <span style="font-family:cursive;">Post</span></p>
                        </div>
                        <div class="col-md-4" style="cursor:pointer" onclick="window.location.href = '{{ url('profile/following/'.$user->id) }}'">
                            <p style="font-size:20px;text-align:center;"><b>{{ $following }}</b> <span style="font-family:cursive;">Following</span></p>
                        </div>
                        <div class="col-md-4" style="cursor:pointer" onclick="window.location.href = '{{ url('profile/followers/'.$user->id) }}'">
                            <p style="font-size:20px;text-align:center;"><b>{{ $followers }}</b> <span style="font-family:cursive;">Followers</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if(Auth::user()->id != $user->id && Auth::user()->status == 1)
                                @php
                                    $statusFollow = 1;
                                    $statusFollow = App\User::find(Auth::user()->id)->hasFollowUser($user->id);
                                @endphp
                                <a href="{{ url(($statusFollow ? "unfollow" : "follow")."/".$user->id) }}"
                                    class="btn btn-{{ $statusFollow ? "danger" : "success" }} btn-sm btn-block">
                                    <i class="fas fa-user-{{ $statusFollow ? "times" : "plus" }}"></i>&nbsp;
                                    {{ $statusFollow ? "Unfollow" : "Follow" }}
                                </a>
                            @endif
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            @if($user->about_me != '')
                                <p>{!! $user->about_me !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- <b style="font-size:25px; color:#1abc9c">Terjemahan</b> --}}
                    <ul class="list-group">
                        @foreach($trans as $translate)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-1">
                                    <img src="{{ asset('storage/'.$translate->user->avatar) }}" width="100px" style="border-radius:50px;" onerror="this.src='{{ asset('storage/no-image.png') }}'">
                                </div>
                                <div class="col-md-10">
                                    <a href="{{ url('profile/'.$translate->user->id) }}" style="font-weight:bold;color:black">
                                        {{ $translate->user->name }}
                                    </a><br>
                                    <a href="{{ url('terjemahan/'.$translate->id) }}">
                                        {{ $translate->dariKata->kata }} - {{ $translate->tujuanKata->kata }}
                                    </a><br>
                                    <span>
                                        <i style="font-size:12px">{{ $translate->created_at->diffForHumans() }}</i>
                                    </span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    {{ $trans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
