@extends('layouts.app')
@section('style')
<style>
    .like-icon .off {
        color:gray;
        cursor:pointer;
    }

    .like-icon .on {
        color:red;
        cursor:pointer;
    }
    .comment-icon .off {
        color:gray;
        cursor:pointer;
    }

    .comment-icon .on {
        color:black;
        cursor:pointer;
    }

    .comment h5 {
        font-size: 20px;
    }

    .comment p {
        color: black;
        font-size: 15px;
    }
    .ganjil {
        background-color: #bdbdff;
        padding: 5px 5px 5px 5px;
    }

    .genap {
        background-color: white;
        padding: 5px 5px 5px 5px;
    }
</style>
@endsection
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
        type : "get",
        data : {
            user: User.id ? User.id : 0
        }
    }).done((result) => {
        next_page_url = result.next_page_url
        console.log(result)
        putToHtml(result.data);
    });
}

function putToHtml(data) {
    let html = ``;
    $.each(data, (key,value) => {
        let liked = "off";
        if(User != {}) {
            liked = (value.rated.find((data) => { return data.user_id == User.id}) != undefined) ? "on" : "off";
        }
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
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url('terjemahan') }}/`+value.id+`"><b>`+ value.dari_kata.kata +` - `+ value.tujuan_kata.kata +`</b></a><Br>
                            Translate dari <i>`+ value.dari_kata.bahasa.nama +`</i> ke <i>`+ value.tujuan_kata.bahasa.nama +`</i><br>
                        </div>
                        @if(!Auth::guest())
                            <div class="col-md-2 like-icon" onclick='toggleLike(this,`+value.id+`)'>
                                <span class="`+liked+`"><i class="fas fa-heart"><span>`+value.rate+`</span></i> Suka</span>
                            </div>
                        @endif
                        <div class="col-md-2 comment-icon" onclick='toggleComment(this, `+value.id+`)'>
                            <span class="off"><i class="fas fa-comments"></i> Komentar</span>
                        </div>
                        <div class="col-md-12">
                            <span id="comment-section`+value.id+`"></span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        `;
    });
    $('#translate-body').append(html);
    loading = false;
}

function toggleLike(e, translate_id) {
    $.ajax({
        async : true,
        url : "{{ url('api/like') }}",
        data : {
            translate_id : translate_id,
            user_id : User.id
        },
        type : "POST"
    }).done((result) => {
        console.log(result);
        let span = $(e).find('span');
        $(span).find('span').html(result.rate);
        if($(span).hasClass('on')) {
            $(span).removeClass('on').addClass('off');
        } else {
            $(span).removeClass('off').addClass('on');
        }
    }).fail((error) => {
        console.log('error')
    });
}

function toggleComment(e, id) {
    let span = $(e).find('span');
    if($(span).hasClass('on')) {
        el.empty();
        $(span).removeClass('on').addClass('off');
    } else {
        loadComment(id);
        $(span).removeClass('off').addClass('on');
    }
}

function loadComment(id)
{
    $.ajax({
        async: true,
        url: "{{ url('api/loadComment') }}",
        data: {
            translate_id : id,
            user_id: User.id
        },
        type: "POST"
    }).done(result => {
        console.log(result);
        el = $("#comment-section"+id);
        el.empty();
        if(result.length == 0) {
            showNoComment(el, id);
        } else {
            generateComment(el, result, id);
        }
    }).fail((error) => {
        alert('ada yang salah di sistem saat mencoba mengambil data komentar.')
    });
}

function showNoComment(el, id)
{
    let uniq = Math.floor(Math.random()*100000);
    @if(!Auth::guest())
        el.append("<textarea id='comment-box_"+uniq+"' class='form-control' placeholder='Tulis Komentar Anda'></textarea><br>");
    @endif
    el.append("<p>No Comment</p>");
    plantKey("#comment-box_"+uniq, id);
}

function plantKey(el, id) {
    console.log(el);
    $(el).focus(() => {
        $(this).keyup((e) => {
            if(e.keyCode == 13) {
                let comment = $(el).val();
                postComment(comment, $(el), id);
            }
        });
    });
}

function postComment(comment, el, id)
{
    el.val('');
    $.ajax({
        async :false,
        url: "{{ url('api/postComment') }}",
        data: {
            comment: comment,
            translate_id: id,
            user_id: User.id
        },
        type: "POST"
    }).done(result => {
        if(result == 'sukses') {
            loadComment(id);
        }
        console.log(result)
    });
}

function generateComment(el, data, id)
{
    let uniq = Math.floor(Math.random()*100000);
    console.log(data);
    let html = '';
    @if(!Auth::guest())
    el.append("<textarea id='comment-box_"+uniq+"' class='form-control' placeholder='Tulis Komentar Anda'></textarea><br>");
    @endif
    let i = 1;
    let tipe = 'ganjil';
    $.each(data, (key, value) => {
        if(i%2 != 0 ) { tipe = "ganjil" } else { tipe = "genap" }
        html += `<div class="comment `+tipe+`">`
        html += `
            <h5><b>`+value.user.name+`</b></h5>
            <span style="font-size:12px">`+value.created_at+`</span>
            <p>`+value.comment+`</p>
        `
        html += "</div>";
        i++;
    });
    el.append(html);
    plantKey("#comment-box_"+uniq, id);
}
</script>
@endsection
