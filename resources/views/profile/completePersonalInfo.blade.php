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

    function enableBorn(){
        document.getElementById('born_city').removeAttribute("disabled");
        document.getElementById('born_city').value = "";
        document.getElementById('iBorn').style.display = 'none';
    }

    function enableLiving(){
        document.getElementById('living_city').removeAttribute("disabled");
        document.getElementById('living_city').value = "";
        document.getElementById('iLiving').style.display = 'none';
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
                                    <label for="living_city" class="col-md-4 col-form-label">Citt&agrave; di residenza</label>
                                    <div class="col-md-8">
                                        @if(!empty(old('living_city')))
                                            <input type="text" id="living_city" name="living_city" class="form-control" value="{{ old('living_city')}}">
                                        @else
                                            @if($user->livingCity()->count())
                                                <i class="inside fas fa-pencil-alt" id="iLiving" onclick="enableLiving()"></i>
                                                <input type="text" id="living_city" name="living_city" class="form-control" value="{{$user->livingCity()->getResults()->text}}" disabled="disabled">
                                            @else
                                                <input type="text" id="living_city" name="living_city" class="form-control" value="">
                                            @endif
                                        @endif
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
                                    <label for="born_city" class="col-md-4 col-form-label">Citt&agrave; di nascita</label>
                                    <div class="col-md-8">
                                        @if(!empty(old('born_city')))
                                            <input type="text" id="born_city" name="born_city" class="form-control" value="{{ old('born_city')}}">
                                        @else
                                            @if($user->bornCity()->count())
                                                <i class="inside fas fa-pencil-alt" id="iBorn" onclick="enableBorn()"></i>
                                                <input type="text" id="born_city" name="born_city" class="form-control" value="{{$user->bornCity()->getResults()->text}}" disabled="disabled">
                                            @else
                                                <input type="text" id="born_city" name="born_city" class="form-control" value="">
                                            @endif
                                        @endif
                                        <input type="hidden" id="born_city_id" name="born_city_id" value="{{ old('born_city_id') }}">
                                        <input type="hidden" id="born_city_lat" name="born_city_lat" value="{{ old('born_city_lat') }}">
                                        <input type="hidden" id="born_city_lng" name="born_city_lng" value="{{ old('born_city_lng') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="university" class="col-md-4 col-form-label">Universit&agrave;</label>
                                    <div class="col-md-8">
                                        <input type="text" id="university" name="university" class="form-control" value="{{ old('university') }}" placeholder="Inserisci la tua Università">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="job" class="col-md-4 col-form-label">Lavoro</label>
                                    <div class="col-md-8">
                                        <input type="text" id="job" name="job" class="form-control" value="{{ (old('job')) ? old('job') : $user->job }}" placeholder="Inserisci il tuo lavoro">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label">Descrizione</label>
                                    <div class="col-md-8">
                                        <textarea placeholder="Scrivi una breve descrizione di te..." rows="4" maxlength="150" id="description" name="description" class="form-control" value="{{ old('description') }}"></textarea>
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

@section("styles")
<style>
textarea{
    resize:none;
}
.inside {
position:absolute;
text-indent:5px;
margin-top:10px;
cursor:pointer;
}

#living_city,#born_city {
text-indent:20px;
}

</style>
@endsection