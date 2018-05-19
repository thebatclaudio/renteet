@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Primo passo</h6>
    <h3 class="step-title">Di che ambiente si tratta?</h3>


    <form class="form-horizontal" method="POST" action="">
        {{ csrf_field() }}
        
        <div class="row">
            <div class="col-md-6">
                <label for="tipologia">Scegli una tipologia</label>
                <select name="tipologia" class="form-control">
                    <option value="-1" disabled selected required>Selezionane una</option>
                    @foreach($houseTypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="margin-left" for="address">Inserisci l'indirizzo</label>
                <input id="address" name="address" class="form-control margin-left" type="text" placeholder="Inserisci una via" />
                <input id="address_id" name="address_id" type="hidden" />
                <input id="address_lat" name="address_id" type="hidden" />
                <input id="address_lng" name="address_id" type="hidden" />
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="max_guests">Quante persone puoi ospitare?</label>
                <input id="max_guests" name="max_guests" class="form-control" type="number" min="0" default="0" />
            </div>
            <div class="col-md-6">
                <label class="margin-left" for="bedrooms">Quante stanze da letto sono presenti?</label>
                <input id="bedrooms" name="bedrooms" class="form-control margin-left" type="number" min="0" default="0" />
            </div>
        </div>
        
        <div class="actions margin-top-20 text-right">
            <button type="submit" class="btn btn-primary btn-lg">Avanti</button>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("maps", "3.x", {callback: initialize, other_params:'sensor=false&libraries=places&key=AIzaSyAgn7e4Tc95WlmbyqCz71oGDctx3rXf6oQ'});
    function initialize() {
        var inputAddress = document.getElementById('address');
        var autocompleteAddress = new google.maps.places.Autocomplete(inputAddress, { types: ['address'], region:'EU' });
        google.maps.event.addListener(autocompleteAddress, 'place_changed', function() {
            var place = autocompleteAddress.getPlace();
            if (!place.geometry) {
                return;
            }

            document.getElementById('address_id').value = place.id;
            document.getElementById('address_lat').value = place.geometry.location.lat();
            document.getElementById('address_lng').value = place.geometry.location.lng();
        });
    }

    function validationFunction() {

        if(!$("#address_id").val()) {
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