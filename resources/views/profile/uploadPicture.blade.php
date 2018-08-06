@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('content')
<div class="container margin-top-20">
    <h1 class="page-title text-center">{{'Carica la tua immagine del profilo'}}</h1>
    <div class="row margin-top-20">
        <div class="col-md-12 text-center">
            <h3>Scegli un'immagine che ti rappresenti per poter trovare i coinquilini perfetti per te</h3>
            <div class="panel-body margin-top-80">
                <form class="form-horizontal" method="POST" action="{{ route('upload-picture') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                        <div class="row justify-content-center">
                            <div class="col-md-4">

                                <input id="profile_picture" type="file" class="form-control" name="profile_picture" value="{{ old('profile_picture') }}" required autofocus>

                                @if ($errors->has('profile_picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Carica la tua immagine del profilo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
