@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Terjemahan Baru<h4>
            <form action="" method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('kata') ? 'has-error' : ''}}">
                    <label>Kata</label>
                    <input type="text" readonly name="kata" value="{{ $kata->kata }}" class='form-control' style="color:black">
                    {!! $errors->first('kata', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('bahasa_asal') ? 'has-error' : ''}}">
                    <label>Dari Bahasa</label>
                    <input type="text" readonly value="{{ $kata->bahasa->nama }}" class='form-control' style="color:black">
                    <input type="hidden" name="bahasa_asal" value="{{ $kata->bahasa->id }}">
                    {!! $errors->first('bahasa_asal', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('ke_bahasa') ? 'has-error' : ''}}">
                    <label>Ke Bahasa</label>
                    <select class="form-control" name="ke_bahasa">
                        @foreach($bahasa as $bhs)
                            <option value="{{ $bhs->id }}">{{ $bhs->nama }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('ke_bahasa', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group {{ $errors->has('translate') ? 'has-error' : ''}}">
                    <label>Translate</label>
                    <input type="text" class="form-control" name="translate">
                    {!! $errors->first('translate', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
