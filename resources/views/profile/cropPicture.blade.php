@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
<style>
.croppie-container {
    height: auto;
}

.croppie-container .cr-boundary {
    width: 100%;
    height: 400px;
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
    <div class="container margin-top-20">
        <h1 class="page-title text-center">{{'Ritaglia la tua immagine del profilo'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form id="crop-form" class="form-horizontal" method="POST" action="{{ route('crop-picture') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="panel-body text-right">
                            <div class="row justify-content-center">
                                <div class="col-sm-4 text-center">
                                    <div id="image-to-crop"></div>

                                    <button type="button" id="crop-btn" class="btn btn-lg btn-success">Ritaglia</button>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" id="blob" name="blob" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
