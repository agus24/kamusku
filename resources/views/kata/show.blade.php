@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">asdfasdf</div>
                <div class="card-body">
                    <div class="col-md-2 float-right">
                        <form action="" method="GET">
                            <input type="text" class="form-control" name="search" placeholder="search" value="{{ $_GET['search'] ?? "" }}">
                        </form><br>
                    </div>
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th>Kata</th>
                            <th>Jumlah Translate</th>
                            <th>Action</th>
                        </thead>
                        @foreach($kata as $value)
                            <tr>
                                <td>{{ $value->kata }}</td>
                                <td>{{ $value->jumlahTranslate() }}</td>
                                <td><a href="{{ url('translate/create/'.$value->id) }}" class="btn btn-primary">Buat Terjemahan Baru</a></td>
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
