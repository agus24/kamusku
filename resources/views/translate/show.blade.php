@extends('layouts.app')
@include('helper')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(!Auth::guest())
                                @php $hasFollow = Auth::user()->hasFollowBahasa($translate->dariKata->bahasa->id); $tipeFollow = $hasFollow ? "unfollow" : "follow"; @endphp
                                <button class="btn btn-{{$hasFollow ? "danger" : "success"}}"
                                    {{ Auth::guest() ? "disabled" : "" }}
                                    onclick="window.location.href='{{url("bahasa/".$tipeFollow."/".$translate->dariKata->bahasa->id)}}'"
                                >
                                {{ $hasFollow ? "Berhenti meng" : "" }}ikuti Bahasa {{ $translate->dariKata->bahasa->nama }}</button>
                                @php $hasFollow = Auth::user()->hasFollowBahasa($translate->tujuanKata->bahasa->id); $tipeFollow = $hasFollow ? "unfollow" : "follow"; @endphp
                                <button class="btn btn-{{$hasFollow ? "danger" : "success"}}"
                                    {{ Auth::guest() ? "disabled" : "" }}
                                    onclick="window.location.href='{{url("bahasa/".$tipeFollow."/".$translate->tujuanKata->bahasa->id)}}'"
                                >
                                {{ $hasFollow ? "Berhenti meng" : "" }}ikuti Bahasa {{ $translate->tujuanKata->bahasa->nama }}</button>
                            @endif
                            <br>
                            <br>
                        </div>
                        <div class="col-md-2">
                            <img src="{{ asset('storage/'.$translate->user->avatar) }}" width="50%"><br>
                            <span style="font-size:15px">
                                <b>{{ $translate->user->name }}</b>
                            </span><br>
                            <button class="btn btn-{{ ($hasLike) ? "danger" : "default" }}"
                                {{ Auth::guest() ? "disabled" : "" }}
                                onclick="window.location.href='{{url('terjemahan/'.$id.'/like')}}'"
                            >
                            {{ $translate->rated->count() }} Like</button>
                            </span>
                        </div>
                        <div class="col-md-10">
                            <b>Terjemahan dari {{ $translate->dariKata->bahasa->nama }} Ke {{ $translate->tujuanKata->bahasa->nama }}</b>
                            <div class="row">
                                <div class="col-md-5">
                                    <p><b>{{ $translate->dariKata->kata }}</b></p>
                                    <p>{!! closetags($translate->dariKata->contoh_kalimat) !!}</p>
                                </div>
                                <div class="col-md-5">
                                    <p><b>{{ $translate->tujuanKata->kata }}</b></p>
                                    <p>{!! $translate->tujuanKata->contoh_kalimat ?? "Tidak Ada Contoh Kalimat" !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-section" style="margin-left:10%">
                        <hr>
                        <h5>Komentar</h5>
                        @if(!Auth::guest())
                            <div class="col-md-12">
                                <form action="{{ url('comment/'.$id) }}" method="POST">
                                    {!! csrf_field() !!}
                                    <input id='comment-box' class='form-control' name="comment" placeholder='Tulis Komentar Anda' type="text" required>
                                </form>
                            </div>
                        @endif
                        <hr>
                        @foreach($translate->comments()->orderBy('created_at','desc')->get() as $comment)
                            <div class="row">
                                <div class="col-md-2">
                                    <center>
                                        <img src="{{ asset('storage/'.$comment->user->avatar) }}" width="25%"><br>
                                        <span style="font-size:15px">
                                            <b>{{ $comment->user->name }}</b>
                                        </span>
                                    </center>
                                </div>
                                <div class="col-md-10">
                                    {!! $comment->comment !!}
                                    <br>
                                    <span style="color:gray;font-size:12px">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
