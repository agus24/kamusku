@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-body">
                    @if(!Auth::guest())
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ url('bahasa') }}" class="btn btn-primary btn-block">Buat Translate Baru</a>
                            </div>
                        </div>
                        <hr>
                    @endif
                    @foreach($translate as $trans)
                        <div class="row">
                            <div class="col-md-1">
                                <a href="{{ url('profile/'.$trans->user->id) }}">
                                    <center>
                                        <img src="{{ asset('storage/'.$trans->user->avatar) }}" width="50%"><br>
                                        <span style="font-size:15px">{{ $trans->user->name }}</span>
                                    </center>
                                </a>
                            </div>
                            <div class="col-md-11">
                                <b>{{ $trans->dariKata->kata }} - {{ $trans->tujuanKata->kata }}</b><Br>
                                Translate dari <i>{{ $trans->dariKata->bahasa->nama }}</i> ke <i>{{ $trans->tujuanKata->bahasa->nama }}</i><br>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
