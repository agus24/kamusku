@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-header">Translate</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label id="label-dari">Dari</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-5 form-group">
                            <label id="label-ke">Ke</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-1 form-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary">
                                Translate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
