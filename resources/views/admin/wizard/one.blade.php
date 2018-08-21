@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Primo passo</h6>
    <h3 class="step-title">Di che ambiente si tratta?</h3>

    <hr>

    <form class="form-horizontal" method="POST" action="{{route('admin.house.wizard.one.save')}}" autocomplete="off">
        {{ csrf_field() }}
        
        <div class="row">
            <div class="col-md-6">
                <label for="tipologia">Scegli una tipologia</label>
                <select name="tipologia" class="form-control" required>
                    <option value="-1" disabled selected required>Selezionane una</option>
                    @foreach($houseTypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="address">Inserisci l'indirizzo</label>
                <div class="row">
                    <div class="col-md-10" style="padding-right: 1px">
                        <input id="address" name="renteet_house_address" class="form-control w-100" type="text" placeholder="Inserisci una via" required autocomplete="stocazzo" />
                    </div>
                    <div class="col-md-2" style="padding-left: 1px">
                        <input id="address_number" name="address_number" class="form-control w-100" type="text" placeholder="N°" required />
                    </div>
                </div>
                
                <input id="address_lat" name="address_lat" type="hidden" />
                <input id="address_lng" name="address_lng" type="hidden" />
                <input id="address_city" name="address_city" type="hidden" />
                <input id="address_name" name="address_name" type="hidden" />
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="mq">Quante &egrave; grande il tuo immobile?</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">m<sup>2</sup></span>
                    </div>
                    <input id="mq" name="mq" class="form-control col-md-7" type="number" min="1" value="0" required aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-6">
                <label for="bathrooms">Quanti bagni sono presenti?</label>
                <input id="bathrooms" name="bathrooms" class="form-control" type="number" min="1" value="0" required />
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="bedrooms">Quante stanze da letto sono presenti?</label>
                <input id="bedrooms" name="bedrooms" class="form-control" type="number" min="1" value="0" required />
            </div>
        </div>

        <div id="rooms-container" style="display: none">
            <h5 class="step-title margin-top-40">Posti letto</h5>

            <div id="rooms-container-inputs"></div>
        </div>
        
        <div class="actions margin-top-20 text-right">
            <button type="submit" id="next-button" class="btn btn-primary btn-lg">Avanti</button>
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
            html += '<div class="row"><div class="col-md-6"><label for="bedrooms">Stanza '+(i+1)+'</label><input name="rooms[]" class="form-control" type="number" min="1" default="0" /></div>';
            html += '<div class="col-md-4"><label for="prices">Prezzo mensile per posto letto</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;">€</span></div><input name="prices[]" class="form-control" type="number" min="1" default="0" /><div class="input-group-append"><span class="input-group-text">.00</span></div></div></div>';
            html += '</div>';
        }

        $("#rooms-container-inputs").html(html);
    });
</script>
@endsection