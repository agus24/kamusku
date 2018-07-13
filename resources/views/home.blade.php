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

    .todo-search:before {
        content:""
    }

    .todo-search {
        font-weight:bold;
    }

    .todo li:after {
        display:none
    }
    .tabs {
      background: #34485d;
      height: 51px;
      margin: 0;
      padding: 0;
      list-style-type: none;
      width: 100%;
      position: relative;
      display: block;
      margin-bottom: 20px;
    }
    .tabs li {
      display: block;
      float: left;
      margin: 0;
      padding: 0;
      width: 33%;
    }
    .tabs a {
      background: #34485d;
      display: block;
      float: left;
      text-decoration: none;
      color: white;
      text-align:center;
      width: 100%;
      font-size: 16px;
      padding: 12px 22px 12px 22px;
      /*border-right: 1px solid @tab-border;*/

    }
    .tabs li:last-child a {
      border-right: none;
      padding-left: 0;
      padding-right: 0;
      width: 100%;
      text-align: center;
    }
    .tabs a.active {
      background: #41bc9c;
      border-right: none;
      width: 100%;
      -webkit-transition: all 0.5s linear;
    	-moz-transition: all 0.5s linear;
    	transition: all 0.5s linear;
    }
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9 col-md-pull-3 col-xs-8 col-xs-push-4">
            <div class="card">
                <div class="card-body">
                    @if(!Auth::guest())
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" id="buttonCreate" onclick="openNewTranslate()">Buat Translate Baru</button>
                                <form action="{{ url('terjemahan') }}" method="POST" style="display:none" id="formCreate">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>Bahasa awal</label>
                                        <select class="form-control" name="dari_bahasa" id="dari_bahasa" required>
                                            <option value="">Select</option>
                                            @foreach($bahasa as $bhs)
                                                <option value="{{$bhs->id}}">{{$bhs->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bahasa Tujuan</label>
                                        <select class="form-control" name="tujuan_bahasa" required>
                                            <option value="">Select</option>
                                            @foreach($bahasa as $bhs)
                                                <option value="{{$bhs->id}}">{{$bhs->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="kata_group">
                                        <label>Kata</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="text_kata" value="" required>
                                            <input type="hidden" name="kata_id" id="hdn_kata" value="" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick="searchKata()">Search</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Arti</label>
                                        <input type="text" class="form-control" name="translate" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contoh Kalimat</label>
                                        <textarea class="form-control" name="contoh_kalimat"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-primary">
                                    <input type="button" class="btn btn-default" value="Batal" id="buttonBatal">
                                </form>
                            </div>
                        </div>
                        <hr>
                    @endif
                    <ul class="tabs">
                        <li><a href="#login" class="active" tipe="semua">Semua</a></li>
                        <li><a href="#register" tipe="bahasa">Bahasa</a></li>
                        <li><a href="#reset" tipe="user">User</a></li>
                    </ul>
                    <div id="translate-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-4 col-xs-pull-8">
            <div class="span4">
                <div class="todo mrm">
                    <div class="todo-search">
                        User Terpopuler
                    </div>
                    <ul>
                    @foreach($terpopuler as $pop)
                        <li class="" onclick="window.location.href='{{ url('profile/'.$pop->user->id) }}'">
                            <div class="todo-icon"></div>
                            <div class="todo-content">
                                <h4 class="todo-name">
                                    {{ $pop->user->name }}
                                </h4>
                                <span style="color:green">{{ $pop->total_kontribusi }} Terjemahan</span>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    @include('modal.home')
@endsection

@section('script')
<script>
    let tipe = "semua";
    let oldTipe = "semua";
    (function( $ ) {
      // constants
      var SHOW_CLASS = 'show',
          HIDE_CLASS = 'hide',
          ACTIVE_CLASS = 'active';

      $( '.tabs' ).on( 'click', 'li a', function(e){
        e.preventDefault();
        var $tab = $( this ),
             href = $tab.attr( 'href' );
        tipe = $tab.attr('tipe');

         $( '.active' ).removeClass( ACTIVE_CLASS );
         $tab.addClass( ACTIVE_CLASS );

         $( '.show' )
            .removeClass( SHOW_CLASS )
            .addClass( HIDE_CLASS )
            .hide();

          $(href)
            .removeClass( HIDE_CLASS )
            .addClass( SHOW_CLASS )
            .hide()
            .fadeIn( 550 );
        console.log(tipe);
        next_page_url = "{{ url('api/loadTranslate') }}?page=1";
        loadTranslate();
        console.log('called');
      });
    })( jQuery );
</script>
<script src="{{ asset('js/home.js') }}"></script>
<script>
let next_page_url = "{{ url('api/loadTranslate') }}?page=1";
let oldUrl = "";
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
    console.log(next_page_url);
    if(oldTipe != tipe) {oldUrl = '';}
    if(oldUrl != next_page_url) {
        $.ajax({
            async : true,
            url : next_page_url,
            type : "get",
            data : {
                user: User.id ? User.id : 0,
                tipe: tipe
            }
        }).done((result) => {
            console.log(result.next_page_url);
            oldUrl = next_page_url;
            next_page_url = result.next_page_url == null ? "no" : result.next_page_url;
            console.log(oldUrl);
            if(oldTipe != tipe) {
                $('#translate-body').empty();
                oldTipe = tipe;
            }
            putToHtml(result.data);
        });
    }
    loading = true;
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
                <div class="col-md-2">
                    <a href="{{ url('profile/') }}/`+value.user.id+`">
                        <center>
                            <img src="{{ asset('storage/') }}/`+value.user.avatar+`" width="50%"><br>
                            <span style="font-size:15px">`+value.user.name+`</span>
                        </center>
                    </a>
                </div>
                <div class="col-md-10">
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
