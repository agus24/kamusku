@extends('layouts.app')
@section('style')
<style>
    .profile-picture {
        border-radius: 50px;
    }
</style>
@endsection

@section('content')
<div class="row">
<div class="col-md-12">
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                Profile Edit
            </h5>
            <form action="{{ url('profile/'.$id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" name="img" id="img" class="form-control">
                    </div>
                    <div class="form-group {{ $errors->has('nama') ? "has-error" : "" }}">
                        <label>Nama</label>
                        <input type="Text" name="nama" placeholder="nama" value="{{ $user->name }}" class="form-control">
                        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('password') ? "has-error" : "" }}">
                        <label>Password <sub style="color:red">(kosongkan jika tidak ingin mengganti password)</sub></label>
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('password_confirmation') ? "has-error" : "" }}">
                        <label>Password Confirmation <sub style="color:red">(kosongkan jika tidak ingin mengganti password)</sub></label>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        <label>About Me</label>
                        <textarea class="form-control" name="about_me" rows="10" id="myEditor">
                            {!! old('about_me', $user->about_me) !!}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('script')
<Script>
    let url = window.location.href
    $('#myEditor').froalaEditor({toolbarInline: false});
    if(url.split('/')[2] != "localhost") {
        $('.fr-wrapper').find('div')[0].remove();
    }
</script>
@endsection
