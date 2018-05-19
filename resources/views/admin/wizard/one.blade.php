@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Primo passo</h6>
    <h3 class="step-title">Di che ambiente si tratta?</h3>


    <form class="form-horizontal" method="POST" action="{{route('admin.house.wizard.one.save')}}">
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
                <input id="address_lat" name="address_lat" type="hidden" />
                <input id="address_lng" name="address_lng" type="hidden" />
                <input id="address_city" name="address_city" type="hidden" />
                <input id="address_number" name="address_number" type="hidden" />
                <input id="address_name" name="address_name" type="hidden" />
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="bedrooms">Quante stanze da letto sono presenti?</label>
                <input id="bedrooms" name="bedrooms" class="form-control" type="number" min="0" default="0" />
            </div>
        </div>

        <div id="rooms-container" style="display: none">
            <h5 class="step-title margin-top-40">Posti letto</h5>

            <div id="rooms-container-inputs"></div>
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

            document.getElementById('address_lat').value = place.geometry.location.lat();
            document.getElementById('address_lng').value = place.geometry.location.lng();

            for(var i in place.address_components){
                var element = place.address_components[i];

                if(element.types.indexOf('street_number') !== -1) {
                    document.getElementById('address_number').value = element.long_name;
                }

                if(element.types.indexOf('route') !== -1) {
                    document.getElementById('address_name').value = element.long_name;
                }

                if(element.types.indexOf('locality') !== -1) {
                    document.getElementById('address_city').value = element.long_name;
                }
            }
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

    $("#bedrooms").on('change', function() {
        var value = $(this).val();
        var roomsContainer = $("#rooms-container");

        if(value == 0) {
            roomsContainer.hide();
        } else {
            roomsContainer.show();
        }

        var html = '';

        for(var i = 0; i < value; i++) {
            html += '<div class="row"><div class="col-md-6"><label for="bedrooms">Stanza '+(i+1)+'</label><input name="rooms[]" class="form-control" type="number" min="0" default="0" /></div></div>';
        }

        $("#rooms-container-inputs").html(html);
    });
</script>
@endsection