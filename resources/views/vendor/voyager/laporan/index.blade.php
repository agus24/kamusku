@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing')." Terjemahan")

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-study"></i> Translate
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form method="get" class="form-search">
                                <div class="input-group col-md-4 col-md-offset-8" style="margin-bottom: 10px;">
                                    <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="search" value="{{ $_GET['search'] ?? "" }}">
                                </div>
                            </form>
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Terjemahan</th>
                                        <th>Kata Terjemahan</th>
                                        <th>User Pelapor</th>
                                        <th>Laporan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($laporan as $key => $value)
                                <tr>
                                    <td>{{ $key*($_GET['page'] ?? 1)+1 }}.</td>
                                    <td>{{ $value->translate->dariKata->bahasa->nama }} - {{ $value->translate->tujuanKata->bahasa->nama }}</td>
                                    <td>{{ $value->translate->dariKata->kata }} - {{ $value->translate->tujuanKata->kata }}</td>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->laporan }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination">
                                {!! $laporan->appends(['search' => Request::get('search')])->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
