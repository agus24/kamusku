@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($bahasa as $value)
                <div class="col-md-3"><br>
                    <div class="card card-default">
                        <div class="card-header">{{ $value->nama }} ({{$value->daerah}})</div>
                        <div class="card-body">
                            <a href="{{ url('kata/'.$value->id) }}"
                                class="btn btn-embossed btn-inverse">Daftar Kata</a>
                            @if(!Auth::guest())
                                @if(!Auth::user()->hasFollowBahasa($value->id))
                                    <a href="{{ url('bahasa/follow/'.$value->id) }}"
                                    class="btn btn-embossed btn-success">Ikuti</a>
                                @else
                                    <a href="{{ url('bahasa/unfollow/'.$value->id) }}"
                                    class="btn btn-embossed btn-default">Ikuti</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
