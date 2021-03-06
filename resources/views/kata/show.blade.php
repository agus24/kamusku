@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">Daftar Kata Bahasa {{ $bahasa->nama }}</div>
                <div class="card-body">
                    <div class="col-md-2 float-right">
                        <form action="" method="GET">
                            <input type="text" class="form-control" name="search" placeholder="search" value="{{ $_GET['search'] ?? "" }}">
                        </form><br>
                    </div>
                    <table class="table table-responsive">
                        <thead>
                            <th width="40%">Kata</th>
                            <th width="10%">Jumlah Translate</th>
                            <th width="50%">Action</th>
                        </thead>
                        @foreach($kata as $value)
                            <tr>
                                <td>{{ $value->kata }}</td>
                                <td>{{ $value->jumlahTranslate() }}</td>
                                @if(!Auth::guest())
                                @if(Auth::user()->status == 1)
                                <td><a href="{{ url('translate/create/'.$value->id) }}" class="btn btn-primary">Buat Terjemahan Baru</a></td>
                                @endif
                                @endif
                            </tr>
                        @endforeach
                    </table>
                    <div class="pagination">
                        {!! $kata->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
