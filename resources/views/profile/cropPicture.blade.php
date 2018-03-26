@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
<style>
.croppie-container .cr-boundary {
    width: 500px;
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
            url: '{{\Auth::user()->profile_pic}}'
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
    <div class="container">
        <div class="row margin-top-40">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <h1 class="page-title">{{'Ritaglia la tua immagine del profilo'}}</div>

                    <form id="crop-form" class="form-horizontal" method="POST" action="{{ route('crop-picture') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="panel-body">
                            <div id="image-to-crop"></div>

                            <button type="button" id="crop-btn" class="btn btn-success">Salva</button>
                        </div>

                        <input type="hidden" id="blob" name="blob">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
