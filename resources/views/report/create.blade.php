@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-danger">
                <div class="card-header" style="color:white">Pelaporan Terjemahan</div>
                <div class="card-body" style="background-color:white !important">
                    <div>
                        Pelaporan Terjemahan untuk terjemahan <br>
                        Dari Bahasa
                        <span style="color:blue"><i>{{ $translate->dariKata->bahasa->nama}}</i></span>
                         Ke Bahasa
                        <span style="color:blue"><i>{{ $translate->tujuanKata->bahasa->nama}}</i></span><br>
                        dengan Kata
                        <span style="font-style:italic;color:green">{{ $translate->dariKata->kata }}</span> - <span style="font-style:italic;color:green">{{ $translate->tujuanKata->bahasa->nama}}</span>
                    </div>
                    <div style="border-top: 1px solid black">
                        <h5>Form Pelaporan</h5>
                        <form action="" method="POST">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Laporan</label>
                                <textarea class="form-control" name="laporan"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
