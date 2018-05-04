@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="card-body" id="translate-body">
                    @if(!Auth::guest())
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ url('bahasa') }}" class="btn btn-primary btn-block">Buat Translate Baru</a>
                            </div>
                        </div>
                        <hr>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
let next_page_url = "{{ url('api/loadTranslate') }}?page=1";
let loading = false;

function cekScroll() {
    let scroll = document.documentElement.scrollTop
    let max = document.body.offsetHeight - window.innerHeight;
    if(scroll >= max) {
        // document.documentElement.scrollTop = scroll - 100;
        if(!loading) {
            loadTranslate();
        }
    }
}

setInterval(cekScroll, 200);

function loadTranslate() {
    loading = true;
    $.ajax({
        async : true,
        url : next_page_url,
        type : "GET"
    }).done((result) => {
        next_page_url = result.next_page_url
        console.log(result)
        putToHtml(result.data);
    });
}

function putToHtml(data) {
    let html = ``;
    $.each(data, (key,value) => {
        html += `
            <div class="row">
                <div class="col-md-1">
                    <a href="{{ url('profile/') }}/`+value.user.id+`">
                        <center>
                            <img src="{{ asset('storage/') }}/`+value.user.avatar+`" width="50%"><br>
                            <span style="font-size:15px">`+value.user.name+`</span>
                        </center>
                    </a>
                </div>
                <div class="col-md-11">
                    <b>`+ value.dari_kata.kata +` - `+ value.tujuan_kata.kata +`</b><Br>
                    Translate dari <i>`+ value.dari_kata.bahasa.nama +`</i> ke <i>`+ value.tujuan_kata.bahasa.nama +`</i><br>
                </div>
            </div>
            <hr>
        `;
    });
    $('#translate-body').append(html);
    loading = false;
}
</script>
@endsection
