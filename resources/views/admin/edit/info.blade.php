@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Modifica le informazioni</h6>
    <h3 class="step-title">Di che ambiente si tratta?</h3>

    <hr>

    <form class="form-horizontal" method="POST" action="{{route('admin.house.edit.info.save', $house->id)}}" autocomplete="off">
        {{ csrf_field() }}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-6">
                <label for="tipologia">Scegli una tipologia</label>
                <select name="tipologia" class="form-control" required>
                    <option value="-1" disabled selected required>Selezionane una</option>
                    @foreach($houseTypes as $type)
                        @if($type->id == $house->type->id)
                            <option value="{{$type->id}}" selected>{{$type->name}}</option>
                        @else
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="address">Inserisci l'indirizzo</label>


                <div class="row">
                    <div class="col-10" style="padding-right: 1px">
                        <input id="address" name="renteet_house_address" class="form-control w-100" type="text" placeholder="Inserisci una via" required value="{{$house->street_name}}"/>
                    </div>
                    <div class="col-2" style="padding-left: 1px">
                        <input id="address_number" name="address_number" class="form-control w-100" type="text" placeholder="N°" required value="{{$house->number}}"/>
                    </div>
                </div>
                
                <input id="address_lat" name="address_lat" type="hidden" value="{{$house->getRealLatitude()}}"/>
                <input id="address_lng" name="address_lng" type="hidden" value="{{$house->getRealLongitude()}}"/>
                <input id="address_city" name="address_city" type="hidden" value="{{$house->city}}" />
                <input id="address_name" name="address_name" type="hidden" value="{{$house->street_name}}, {{$house->number}}" />
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="mq">Quanto &egrave; grande il tuo immobile?</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">m<sup>2</sup></span>
                    </div>
                    <input id="mq" name="mq" class="form-control col-md-7" type="number" min="1" value="{{$house->mq}}" required aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-6">
                <label for="bathrooms">Quanti bagni sono presenti?</label>
                <input id="bathrooms" name="bathrooms" class="form-control" type="number" min="1" value="{{$house->bathrooms}}" required />
            </div>
        </div>
        
        <div class="actions margin-top-20 text-right">
            <button type="submit" id="next-button" class="btn btn-primary btn-lg">Salva</button>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("maps", "3.x", {callback: initialize, other_params:'sensor=false&libraries=places&key=AIzaSyAgn7e4Tc95WlmbyqCz71oGDctx3rXf6oQ'});
    
    function populateAddressValues(focus, place) {
        document.getElementById('address_lat').value = place.geometry.location.lat();
        document.getElementById('address_lng').value = place.geometry.location.lng();

        for(var i in place.address_components){
            var element = place.address_components[i];

            if(element.types.indexOf('street_number') !== -1) {
                document.getElementById('address_number').value = element.long_name;
            } else {
                document.getElementById('address_number').style.display = 'block';
                if(focus) $("#address_number").focus();
            }

            if(element.types.indexOf('route') !== -1) {
                document.getElementById('address_name').value = element.long_name;
            }

            if(element.types.indexOf('locality') !== -1) {
                document.getElementById('address_city').value = element.long_name;
            }
        }
    }
    
    function initialize() {
        var inputAddress = document.getElementById('address');
        var autocompleteAddress = new google.maps.places.Autocomplete(inputAddress, { types: ['address'], region:'EU' });
        google.maps.event.addListener(autocompleteAddress, 'place_changed', function() {
            var place = autocompleteAddress.getPlace();
            if (!place.geometry) {
                return;
            }

            populateAddressValues(true, place);
        });
    }

    $(document).ready(function() {
        $(window).keydown(function(event){
            if( (event.keyCode == 13) && ($("#address").is(':focus') ) ) {
                event.preventDefault();
                return false;
            }
        });
    });

    $("#address").focusout(function(){
        var firstResult = $(".pac-container .pac-item:first").text();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({"address":firstResult }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                populateAddressValues(true, results[0]);

                $(".pac-container .pac-item:first").addClass("pac-selected");
                $(".pac-container").css("display","none");
                $("#address").val(firstResult);
                $(".pac-container").css("visibility","hidden");
            }
        });
    });

    $("#address_number").change(function(){
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({"address":$("#address").val()+' '+$(this).val() }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                populateAddressValues(false, results[0]);

                $(".pac-container .pac-item:first").addClass("pac-selected");
                $(".pac-container").css("display","none");
                $("#address").val(firstResult);
                $(".pac-container").css("visibility","hidden");
            }
        });
    });
</script>

<script>
    var rooms = {!!json_encode($house->rooms()->select('id','beds','bed_price')->get()->toArray())!!};

    $("#bedrooms").on('change', function() {
        var value = $(this).val();
        var roomsContainer = $("#rooms-container");

        if(value == 0) {
            roomsContainer.hide();
        } else {
            roomsContainer.show();
        }

        var html = '';
        var length = $('input[name="rooms[]"]').length;

        $('input[name="rooms[]"]').each(function(i) {

            if(typeof rooms[i] === 'undefined') {
                rooms[i] = {
                    id: null,
                    beds: 0,
                    bed_price: 0
                };
            }
            
            rooms[i].beds = $(this).val();

            if(i+1 === length) {
                
                $('input[name="prices[]"]').each(function(i) {
                    rooms[i].bed_price = $(this).val();

                    if(i+1 === length) {
                        for(var i = 0; i < value; i++) {
                            if(typeof rooms[i] !== 'undefined') {
                                html += '<div class="row margin-top-40"><div class="col-md-6"><label for="bedrooms">N<sup>o</sup> posti letto stanza '+(i+1)+'</label><input id="room-'+(i)+'-beds" name="rooms[]" class="form-control" type="number" min="1" value="'+rooms[i].beds+'" /></div>';
                                html += '<div class="col-md-4"><label for="prices">Prezzo mensile per posto letto</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;">€</span></div><input name="prices[]" class="form-control" type="number" min="1" value="'+rooms[i].bed_price+'" /><div class="input-group-append"><span class="input-group-text">.00</span></div></div></div>';
                                html += '</div>';
                            } else {
                                html += '<div class="row margin-top-40"><div class="col-md-6"><label for="bedrooms">N<sup>o</sup> posti letto stanza '+(i+1)+'</label><input id="room-'+(i)+'-beds" name="rooms[]" class="form-control" type="number" min="1" default="0" /></div>';
                                html += '<div class="col-md-4"><label for="prices">Prezzo mensile per posto letto</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;">€</span></div><input name="prices[]" class="form-control" type="number" min="1" default="0" /><div class="input-group-append"><span class="input-group-text">.00</span></div></div></div>';
                                html += '</div>';
                            }
                        }

                        $("#rooms-container-inputs").html(html);

                        $("#room-0-beds").focus();
                    }
                });
            }
        });
    });
</script>
@endsection