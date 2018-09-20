@extends('layouts.app')

@section('title', 'Be friendly')

@section('content')
<div id="main-container" class="container margin-top-20" style="display: none">

    <div class="row d-none d-sm-flex">
        <div class="col-auto">
            @if($locationName)
                <h3>Immobili attualmente disponibili nei dintorni di <strong>{{$locationName}}</strong></h3>
            @else
                <h3>Immobili attualmente disponibili nei tuoi dintorni</h3>
            @endif
        </div>
    </div>
    
    <form id="mobileSearchForm" class="form-inline d-inline-flex d-sm-none w-100" action="{{route('search.coordinates')}}" method="GET">
        <input id="mobileLat" name="lat" type="hidden" required>
        <input id="mobileLng" name="lng" type="hidden" required>
        <input id="mobile-search-input" name="searchInput" class="form-control" type="text" onFocus="geolocate()" value="{{$locationName}}" placeholder="Prova &quot;Palermo&quot;" aria-label="Cerca">
        <i class="search-icon mobile-search-icon fa fa-search fa-2x" aria-hidden="true"></i>
    </form>

    <hr>

    <div class="search-results row margin-top-40">
        @forelse($houses as $house)
            @php
                $bedsCount = 0;
            @endphp
        <div class="house-col col-md-4">
            <div id="house-{{$house->id}}" class="house">
                
                <div class="owner-container">
                    <a class="no-style" href="{{$house->url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                        <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
                        <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
                    </a>
                </div>

                <div class="photos-container">
                    <div class="row">
                        @if(isset($house->photos[1]))
                        <div class="col-md-7">
                        @else
                        <div class="col-md-12">
                        @endif
                            @if(isset($house->photos[0]))
                            <div class="house-img" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name))}})"></div>
                            @else
                            <div class="house-img" style="background-image: url({{URL::to("/images/homepage/background.jpg")}})"></div>
                            @endif
                        </div>
                        <div class="col-md-5">
                            @if(isset($house->photos[1]) && isset($house->photos[2]))
                            <div class="house-img half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name))}})"></div>
                            <div class="house-img half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[2]->file_name))}})"></div>
                            @elseif(isset($house->photos[1]))
                            <div class="house-img" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name))}})"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="house-users text-center text-nowrap margin-top-20">
                    @foreach($house->rooms as $room)
                        @foreach($room->acceptedUsers as $user)
                            @if($bedsCount<3 OR $house->beds == 4)
                                <a href="{{$house->url}}" title="Visualizza l'appartamento" target="_blank">
                                    <img src="{{$user->profile_pic}}" alt="{{$user->name}}" class="rounded-circle small-user-pic border-shadow">
                                </a>
                            @endif
                            @php
                                $bedsCount++;   
                            @endphp     
                        @endforeach
                        @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                            @if($bedsCount<3 OR $house->beds == 4)
                            <a href="{{$house->url}}" title="Visualizza l'appartamento" target="_blank">
                                <img class="rounded-circle border-shadow small-user-pic" src="{{url('/images/free-bed.png')}}" alt="Posto libero" width="80" height="80">
                            </a>
                            @endif
                            @php
                                $bedsCount++; 
                            @endphp    
                        @endfor
                    @endforeach
                    
                    @if($house->beds > 4)
                        <a href="{{$house->url}}" title="Visualizza l'appartamento" target="_blank">
                            <div class="circle more-users border-shadow">
                                + {{$house->beds - 3}}
                            </div>
                        </a>
                    @endif
                
                </div>

                <div class="house-price margin-top-40 text-right d-none d-sm-block">
                    A partire da <strong class="price">{{$house->minorBedPrice()}}€</strong>
                    <a href="{{$house->url}}" class="btn btn-dark btn-sm margin-left-5">Visualizza L'appartamento</a>
                </div>

                <div class="house-price margin-top-40 text-right d-block d-sm-none text-center">
                    A partire da <strong class="price">{{$house->minorBedPrice()}}€</strong><br />
                    <a href="{{$house->url}}" class="btn btn-success margin-top-10 margin-left-5">Visualizza L'appartamento</a>
                </div>
            </div>
        </div>
        @empty
            <div class="col">
                <h4 class="text-muted text-center">Nessun immobile trovato</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
$("#list-view").click(function(){
    window.location = window.location + "?view=list";
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, function() {
            $("#main-container").show();
        });
    } else {
        $("#main-container").show();
    }
}
function showPosition(position) {
    window.location.href = "{{url('/search')}}?lat="+position.coords.latitude+"&lng="+position.coords.longitude;
}

$(document).ready(function() {
    getLocation();
});
</script>
@endsection