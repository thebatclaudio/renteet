@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
<style>
.croppie-container .cr-boundary {
    width: 100%;
    height: 500px;
}
</style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
    <script>
        var basic = $('#image-to-crop').croppie({
            viewport: {
                width: 400,
                height: 400
            }
        });
        basic.croppie('bind', {
            url: '{{\Auth::user()->profile_pic_real_size}}'
        });
        //on button click
        $("#crop-btn").on('click', function () {
            basic.croppie('result', 'base64').then(function(result) {
                console.log(result);
                $("#blob").val(result);
                $("#crop-form").submit();
            });
        })
    </script>
@endsection

@section('content')
    <div class="container-fluid margin-top-20">
        <h1 class="page-title">{{'Ritaglia la tua immagine del profilo'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <form id="crop-form" class="form-horizontal" method="POST" action="{{ route('crop-picture') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="panel-body text-right">
                            <div id="image-to-crop"></div>

                            <button type="button" id="crop-btn" class="btn btn-lg btn-success"><i class="fa fa-check"></i> Ritaglia</button>
                        </div>

                        <input type="hidden" id="blob" name="blob" />
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel-body" style="padding: 60px">

                    <h3>Scegli un'immagine che ti rappresenti così i tuoi coinquilini potranno vedere quanto sei troia e richiedere di entrare nelle case in cui stai per poterti trombare fino a farti piangere.</h3>

                    <form class="form-horizontal margin-top-40" method="POST" action="{{ route('upload-picture') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                            <label for="profile_picture" class="col-md-4 control-label">Scegli un'immagine che ti rappresenta</label>

                            <div class="col-md-6">
                                <input id="profile_picture" type="file" class="form-control" name="profile_picture" value="{{ old('profile_picture') }}" required autofocus>

                                @if ($errors->has('profile_picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 margin-top-40">
                                <button type="submit" class="btn btn-primary">
                                    Cambia la tua immagine del profilo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
@endsection
