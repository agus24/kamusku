@extends('layouts.app')

@section('style')
<style>
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #34485d;
        color: white;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Translate</h1>
            <div class="card">
                <div class="card-header form-inline">
                    <div class="col-md-6 pull-left">
                        <div class="tab first">
                            <button class="tablinks active" onclick="bahasaSelect(event, this)" bahasa="1">Indonesia</button>
                            <button class="tablinks" onclick="bahasaSelect(event, this)" id="lastBhsDr" bahasa="3">Jawa</button>
                            <button class="tablinks" onclick="bahasaSelect(event, this, true)">More <i class="fas fa-caret-down"></i></button>
                        </div>
                        <input type="hidden" id="cmb-dari" value="1">
                    </div>
                    <div class="col-md-4 pull-right" style="text-align:left">
                        <div class="tab second">
                            <button class="tablinks active" onclick="bahasaSelectKe(event, this)" bahasa="1">Indonesia</button>
                            <button class="tablinks" onclick="bahasaSelectKe(event, this)" id="lastBhsKe" bahasa="3">Jawa</button>
                            <button class="tablinks" onclick="bahasaSelectKe(event, this, true)">More <i class="fas fa-caret-down"></i></button>
                        </div>
                        <input type="hidden" id="cmb-ke" value="1">
                    </div>
                    <div class="col-md-2 form-group">
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

@section('modal')
    @include('modal.bahasaMore')
@endsection

@section('script')
<script>
    const src = @json($kata);
    const baseURI = "{{ url('') }}";
</script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection
