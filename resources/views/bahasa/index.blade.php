@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h4>Daftar Bahasa <sub style="font-size:14px">({{ App\Bahasa::get()->count() }} Bahasa)</sub></h4>
                <ul style="font-size:12px">
                    <li><i>Untuk mencari Bahasa dapat menggunakan kolom pencarian di kanan atas</i></li>
                    <li><i>Untuk mengikuti bahasa dapat menggunakan tombol ikuti pada tabel bahasa</i></li>
                </ul>
            </div>
            <div class="col-md-4">
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Cari Bahasa" class="form-control" value="{{ $_GET['search'] ?? "" }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="$('form').submit()">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Daerah</th>
                        <th width="20%">Action</th>
                    </thead>
                    <tbody>
                    @foreach($bahasa as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{$value->daerah}}</td>
                            <td>
                                <a href="{{ url('kata/'.$value->id) }}" class="btn btn-embossed btn-inverse">Daftar Kata</a>
                                @if(!Auth::guest())
                                    @if(!Auth::user()->hasFollowBahasa($value->id))
                                        <a href="{{ url('bahasa/follow/'.$value->id) }}"
                                        class="btn btn-embossed btn-success">Ikuti</a>
                                    @else
                                        <a href="{{ url('bahasa/unfollow/'.$value->id) }}"
                                        class="btn btn-embossed btn-default">Ikuti</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
