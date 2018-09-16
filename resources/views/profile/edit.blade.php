@extends('layouts.app')

@section('title', 'Modifica il tuo profilo')

@section('styles')
<link rel="stylesheet" href="/css/tagsinput.css">
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('.tagsinput').tagsinput({
        confirmKeys: [13,32,188,44]
    });
});
</script>
<script src="/js/tagsinput.js"></script>
@endsection

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
<div class="container">
    <div class="row">
        <div class="page-target-container margin-top-40">
            <h3 class="page-target">Modifica Profilo</h3>
        </div>
    </div>

    <div class="row margin-top-120">

    <?php $found = false; ?>

    <!-- left column -->
        <div class="col-md-3">
            <div class="view overlay">
                <img src="{{$user->profile_pic}}" class="avatar rounded-circle fluid" alt="avatar" style="width:200px; height:200px;">
                <div class="mask flex-center rgba-stylish-strong avatar rounded-circle fluid" style="width:200px; height:200px;">
                    <a class="white-text" href="{{route('show-upload-picture')}}">Modifica Immagine</a>
                </div>
            </div>
        </div>    

    <!-- edit form column -->
        <div class="col-md-9">
            @if ($errors->any())
                <div class="alert alert-info alert-dismissable margin-top-10">
                    <a class="panel-close close" data-dismiss="alert">×</a> 
                    <i class="fas fa-exclamation"></i>
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                @if(strpos($error, 'data di nascita'))
                                    @if(!$found)
                                        <li>{{ $error }}</li>

                                        <?php $found = true; ?>
                                    @endif
                                @else
                                    <li>{{ $error }}</li>
                                @endif
                            @endforeach
                        </ul>
                </div>
            @endif
            <form id="personal-info-form" class="form-horizontal" method="POST" action="{{ route('edit-personal-info') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Dati Utente</h4>
                    </div>
                    <div class="panel-body">

                        <div class="form-group col-sm-10">
                            <label for="first_name" class="col-sm-3 control-label">Nome</label>
                            <div class="col-sm-9 float-right">                              
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ (old('first_name')) ? old('first_name') : $user->first_name }}" required autofocus>                           
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="last_name" class="col-sm-3 control-label">Cognome</label>
                            <div class="col-sm-9 float-right">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ (old('last_name')) ? old('last_name') : $user->last_name }}" required autofocus>                                
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="gender" class="col-sm-3 control-label">Genere</label>
                            <div class="col-sm-9 float-right">

                                @if($user->gender)
                                    <select class="form-control" name="gender" id="gender" value="{{$user->gender}}">
                                    @if($user->gender == "female")
                                        <option value="male">Uomo</option>
                                        <option value="female" selected="selected">Donna</option>
                                        <option value="unknown">Non specificato</option>
                                    @elseif($user->gender == "male")
                                        <option value="male" selected="selected">Uomo</option>
                                        <option value="female">Donna</option>
                                        <option value="unknown">Non specificato</option>
                                    @else
                                        <option value="male">Uomo</option>
                                        <option value="female">Donna</option>
                                        <option value="unknown" selected="selected">Non specificato</option>
                                    @endif
                                @else
                                    <select class="form-control" name="gender" id="gender" value="{{ old('gender') }}">
                                        <option value="male">Uomo</option>
                                        <option value="female">Donna</option>
                                        <option value="unknown">Non specificato</option>
                                @endif   
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="birthday" class="col-sm-3 control-label">Data di Nascita</label>
                            <div class="col-sm-9 float-right">
                                <div class="row">
                                    <div class="col-md-3" style="padding-right: 4px">
                                        <select name="day" class="form-control" value="{{$birth_day}}" required>
                                            <option disabled value="-1">Giorno:</option>
                                            @for($i=1;$i<=31;$i++)
                                                @if($i == $birth_day)
                                                <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6" style="padding: 0px 4px">
                                        <select name="month" class="form-control" required>
                                                <option disabled value="-1">Mese:</option>
                                                @for($i=1;$i<=12;$i++)
                                                    @if($i == $birth_month)
                                                    <option value="{{$i}}" selected="selected">{{$months_it[$i-1]}}</option>
                                                    @else
                                                    <option value="{{$i}}">{{$months_it[$i-1]}}</option>
                                                    @endif
                                                @endfor    
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="padding-left: 4px">
                                        <select name="year" class="form-control" value="{{$birth_year}}" required>
                                            <option disabled value="-1">Anno:</option>
                                            @for($i=(int)date("Y")-18;$i>(int)date("Y")-118;$i--)
                                                @if($i == $birth_year)
                                                <option value="{{$i}}" selected>{{$i}}</option>
                                                @else
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="living_city" class="col-sm-3 control-label">Citt&agrave; di residenza</label>
                            <div class="col-sm-9 float-right">
                                @if(!empty(old('living_city')))
                                    <input type="text" id="living_city" name="living_city" class="form-control" value="{{ old('living_city')}}">
                                    <input type="hidden" name="living_city_required" value="true">
                                @else
                                    @if($user->livingCity()->count())
                                        <input type="text" id="living_city" name="living_city" class="form-control" value="{{$user->livingCity()->getResults()->text}}">
                                    @else
                                        <input type="text" id="living_city" name="living_city" class="form-control" value="">
                                        <input type="hidden" name="living_city_required" value="true">
                                    @endif
                                @endif
                                <input type="hidden" id="living_city_id" name="living_city_id" value="{{ old('living_city_id') }}">
                                <input type="hidden" id="living_city_lat" name="living_city_lat" value="{{ old('living_city_lat') }}">
                                <input type="hidden" id="living_city_lng" name="living_city_lng" value="{{ old('living_city_lng') }}">
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="born_city" class="col-sm-3 control-label">Citt&agrave; di nascita</label>
                            <div class="col-sm-9 float-right">
                                @if(!empty(old('born_city')))
                                    <input type="text" id="born_city" name="born_city" class="form-control" value="{{ old('born_city')}}">
                                    <input type="hidden" name="born_city_required" value="true">
                                @else
                                    @if($user->bornCity()->count())
                                        <input type="text" id="born_city" name="born_city" class="form-control" value="{{$user->bornCity()->getResults()->text}}">
                                    @else
                                        <input type="text" id="born_city" name="born_city" class="form-control" value="">
                                        <input type="hidden" name="born_city_required" value="true">
                                    @endif
                                @endif
                                <input type="hidden" id="born_city_id" name="born_city_id" value="{{ old('born_city_id') }}">
                                <input type="hidden" id="born_city_lat" name="born_city_lat" value="{{ old('born_city_lat') }}">
                                <input type="hidden" id="born_city_lng" name="born_city_lng" value="{{ old('born_city_lng') }}">
                            </div>
                        </div>
  
                    </div>
                </div>

                <hr>

                <div class="panel panel-default margin-top-40">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contatti</h4>
                    </div>
                    <div class="panel-body">

                        <div class="form-group col-sm-10">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9 float-right">
                                <input id="email" type="email" class="form-control" name="email" value="{{ (old('email')) ? old('email') : $user->email }}" required>
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="telephone" class="col-sm-3 control-label">Numero Telefono</label>
                            <div class="col-sm-9 float-right">
                                <input id="telephone" type="tel" class="form-control" name="telephone" value="{{ (old('telephone')) ? old('telephone') : $user->telephone }}">                              
                            </div>
                        </div>

                    </div>
                </div>

                <hr>

                <div class="panel panel-default margin-top-40">
                    <div class="panel-heading">
                        <h4 class="panel-title">Informazioni aggiuntive</h4>
                    </div>
                    <div class="panel-body">

                        <div class="form-group col-sm-10">
                            <label for="university" class="col-sm-3 control-label">Universit&agrave;</label>
                            <div class="col-sm-9 float-right">
                                <input type="text" id="university" name="university" class="form-control" value="{{ (old('university')) ? old('university') : $user->university }}" placeholder="Inserisci la tua Università"> 
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="job" class="col-sm-3 control-label">Lavoro</label>
                            <div class="col-sm-9 float-right">
                                <input type="text" id="job" name="job" class="form-control" value="{{ (old('job')) ? old('job') : $user->job }}" placeholder="Inserisci il tuo lavoro">
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="interests" class="col-sm-3 control-label">Interessi</label>
                            <div class="col-sm-9 float-right">
                                <input type="text" placeholder="I tuoi interessi" name="interests" class="tagsinput" value="{{(old('interests')) ? old('interests') : $interests}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="languages" class="col-sm-3 control-label">Lingue</label>
                            <div class="col-sm-9 float-right">
                                <input type="text" placeholder="Che lingue conosci ?" name="languages" class="tagsinput" value="{{(old('languages')) ? old('languages') : $languages}}">
                            </div>
                        </div>

                        <div class="form-group col-sm-10">
                            <label for="description" class="col-sm-3 control-label">Descrizione</label>
                            <div class="col-sm-9 float-right">
                                <textarea placeholder="Scrivi una breve descrizione di te..." rows="4" maxlength="150" id="description" name="description" class="form-control" style="resize:none;">{{(old('description')) ? old('description') : $user->description}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="row margin-top-60">
                    <button type="submit" class="btn btn-success float-right">Salva</button>
                </div>
            </form>
        </div>
    
    </div>

</div>
@endsection

@section("styles")
<style>
.panel {
  box-shadow: none;
}
.panel-heading {
  border-bottom: 0;
}
.panel-title {
  font-size: 17px;
}
.panel-title > small {
  font-size: .75em;
  color: #999999;
}
.panel-body *:first-child {
  margin-top: 0;
}
.panel-footer {
  border-top: 0;
}

.panel-default > .panel-heading {
    color: #333333;
    background-color: transparent;
    border-color: rgba(0, 0, 0, 0.07);
}

form label {
    color: #999999;
    font-weight: 400;
}

.form-horizontal .form-group {
  margin-left: -15px;
  margin-right: -15px;
}
@media (min-width: 768px) {
  .form-horizontal .control-label {
    text-align: right;
    margin-bottom: 0;
    padding-top: 7px;
  }
}

.profile__contact-info-icon {
    float: left;
    font-size: 18px;
    color: #999999;
}
.profile__contact-info-body {
    overflow: hidden;
    padding-left: 20px;
    color: #999999;
}
.profile-avatar {
  width: 200px;
  position: relative;
  margin: 0px auto;
  margin-top: 196px;
  border: 4px solid #f3f3f3;
}
</style>
@endsection
