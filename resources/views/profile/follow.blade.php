@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                    @foreach($follow as $value)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div onclick="window.location.href='{{ url('profile/'.$value->id) }}'" style="cursor:pointer">
                                <img src="{{ asset('storage/'.$value->avatar) }}" onerror="this.src='{{ asset('storage/no-image.png') }}'" width="50px" style="border-radius:50px">
                                <span style=" font-weight:bold;color:blue">{{ $value->name }}</span>
                            </div>
                            @if(!Auth::guest())
                            @if(Auth::user()->id == $user->id)
                                @php
                                    $statusFollow = 1;
                                    $statusFollow = App\User::find(Auth::user()->id)->hasFollowUser($value->id);
                                @endphp
                                <span class="badge badge-{{$statusFollow ? "danger" : "success"}}"><a href="{{ url(($statusFollow ? "unfollow" : "follow")."/".$value->id) }}" style="color:white">{{$statusFollow ? "Unfollow" : "Follow"}}</a></span>
                            @endif
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
