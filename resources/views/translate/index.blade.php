@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <h1>Translate</h1>
            <div class="card">
                <div class="card-header form-inline">
                    <div class="col-md-6 pull-left">
                        <select class="form-control" style="font-weight:bold;" id="cmb-dari">
                            @foreach($bahasa as $value)
                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 pull-right" style="text-align:left">
                        <select class="form-control" style="font-weight:bold;" id="cmb-ke">
                            @foreach($bahasa as $value)
                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <button class="btn btn-primary" id="btnTranslate">
                            Translate
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label id="label-dari">
                                <b>Dari</b>
                            </label>
                            <input type="text" class="form-control" id="text-dari">
                            <input type="hidden" id="hidden-dari">
                        </div>
                        <div class="col-md-6 form-group">
                            <label id="label-ke">Ke</label>
                            <span id="output" style="background-color:gray">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span id="topResult"></span><br>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align:justify" id="detail-dari">
                        </div>
                        <div class="col-md-6" style="text-align:justify" id="detail-ke">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    const src = @json($kata);
    const baseURI = "{{ url('') }}";
</script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection
