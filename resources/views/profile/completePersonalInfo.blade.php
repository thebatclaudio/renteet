@extends('layouts.app')

@section('title', 'Completa il tuo profilo')

@section('scripts')
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("maps", "3.x", {callback: initialize, other_params:'sensor=false&libraries=places&key=AIzaSyAgn7e4Tc95WlmbyqCz71oGDctx3rXf6oQ'});
    function initialize() {
        var inputLivingCity = document.getElementById('living_city');
        var autocompleteLivingCity = new google.maps.places.Autocomplete(inputLivingCity, { types: ['(cities)'], region:'EU' });
        google.maps.event.addListener(autocompleteLivingCity, 'place_changed', function() {
            var place = autocompleteLivingCity.getPlace();
            if (!place.geometry) {
                return;
            }

            document.getElementById('living_city_id').value = place.id;
            document.getElementById('living_city_lat').value = place.geometry.location.lat();
            document.getElementById('living_city_lng').value = place.geometry.location.lng();
        });

        var inputBornCity = document.getElementById('born_city');
        var autocompleteBornCity = new google.maps.places.Autocomplete(inputBornCity, { types: ['(cities)'], region:'EU' });
        google.maps.event.addListener(autocompleteBornCity, 'place_changed', function() {
            var place = autocompleteBornCity.getPlace();
            if (!place.geometry) {
                return;
            }
            document.getElementById('born_city_id').value = place.id;
            document.getElementById('born_city_lat').value = place.geometry.location.lat();
            document.getElementById('born_city_lng').value = place.geometry.location.lng();
        });
    }

    function validationFunction() {

        if(!$("#living_city_id").val()) {
            return false;
        }

        if(!$("#born_city_id").val()) {
            return false;
        }

        return true;
    }

    $(document).ready(function() {
        $(window).keydown(function(event){
            if( (event.keyCode == 13) && (validationFunction() == false) ) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection

@section('content')
    <div class="container margin-top-20">
        <h1 class="page-title">{{'Completa i tuoi dati'}}</h1>
        <div class="row margin-top-40">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form id="personal-info-form" class="form-horizontal" method="POST" action="{{ route('complete-personal-info') }}" enctype="multipart/form-data">
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
                                        <input type="text" id="living_city" name="living_city" class="form-control" value="{{ old('living_city') }}">
                                        <input type="hidden" id="living_city_id" name="living_city_id" value="{{ old('living_city_id') }}">
                                        <input type="hidden" id="living_city_lat" name="living_city_lat" value="{{ old('living_city_lat') }}">
                                        <input type="hidden" id="living_city_lng" name="living_city_lng" value="{{ old('living_city_lng') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label">Citt&agrave; di nascita</label>
                                    <div class="col-md-8">
                                        <input type="text" id="born_city" name="born_city" class="form-control" value="{{ old('born_city') }}">
                                        <input type="hidden" id="born_city_id" name="born_city_id" value="{{ old('born_city_id') }}">
                                        <input type="hidden" id="born_city_lat" name="born_city_lat" value="{{ old('born_city_lat') }}">
                                        <input type="hidden" id="born_city_lng" name="born_city_lng" value="{{ old('born_city_lng') }}">
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