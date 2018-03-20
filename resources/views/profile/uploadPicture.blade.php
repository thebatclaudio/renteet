@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('content')
<div class="container">
    <div class="row margin-top-40">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <h1 class="page-title">Carica un'immagine del profilo</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('upload-picture') }}" enctype="multipart/form-data">
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
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Carica la tua immagine del profilo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
