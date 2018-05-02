@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('content')
    <div class="container margin-top-20">
        <h1 class="page-title">{{'Completa i tuoi dati'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form class="form-horizontal" method="POST" action="{{ route('complete-personal-info') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @if(isset($error))
                            {{$error}}
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label">Genere</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="gender" id="gender" value="{{ old('gender') }}">
                                            <option value="male">Uomo</option>
                                            <option value="female">Donna</option>
                                            <option value="unknown">Non specificato</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label">Citt&agrave; di residenza</label>
                                    <div class="col-md-8">
                                        <input type="text" name="living_city" class="form-control" value="{{ old('living_city') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label">Citt&agrave; di nascita</label>
                                    <div class="col-md-8">
                                        <input type="text" name="born_city" class="form-control" value="{{ old('born_city') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Salva</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection