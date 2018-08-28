@extends('layouts.app')

@section('title', 'Be friendly')

@section('content')
<div class="container margin-top-20">
    
    <div class="row d-none d-sm-block">
        <div class="col-auto">
            @if($searchInput)
                <h3>Immobili attualmente disponibili nei dintorni di <strong>{{$searchInput}}</strong></h3>
            @else
                <h3>Immobili attualmente disponibili nei tuoi dintorni</h3>
            @endif
        </div>
        <div class="col text-right">
            <div class="btn-group" role="group" aria-label="Cambia la modalità di visualizzazione degli annunci">
                <a class="btn btn-change-view btn-elegant" title="Visualizzazione a griglia" data-view="grid"><i class="fas fa-th"></i></a>
                <a id="list-view" class="btn btn-change-view btn-outline-elegant" title="Visualizzazione a elenco" data-view="list"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>

    <form id="mobileSearchForm" class="form-inline d-inline-flex d-sm-none w-100" action="{{route('search.coordinates')}}" method="GET">
        <input id="mobileLat" name="lat" type="hidden" required>
        <input id="mobileLng" name="lng" type="hidden" required>
        <input id="mobile-search-input" name="searchInput" class="form-control" type="text" onFocus="geolocate()" value="{{\Request::get('searchInput')}}" placeholder="Prova &quot;Palermo&quot;" aria-label="Cerca">
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
                
                <div class="owner-container {{$house->owner->gender}}">
                    <a class="no-style" href="{{$house->owner->profile_url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                        <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
                        <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
                    </a>
                </div>

                <div class="photos-container">
                    <div class="row">
                        @if(isset($house->photos[1]))
                        <div class="col-7 col-md-7">
                            @if(isset($house->photos[0]))
                            <div class="house-img" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name)."-320.jpg")}})"></div>
                            @endif
                        @else
                        <div class="col-12 col-md-12">
                            @if(isset($house->photos[0]))
                            <div class="house-img" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name)."-670.jpg")}})"></div>
                            @endif
                        @endif

                        </div>
                        <div class="col-5 col-md-5">
                            @if(isset($house->photos[1]) && isset($house->photos[2]))
                            <div class="house-img half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name)."-220.jpg")}})"></div>
                            <div class="house-img half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[2]->file_name)."-220.jpg")}})"></div>
                            @elseif(isset($house->photos[1]))
                            <div class="house-img" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name)."-220.jpg")}})"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="house-users text-center text-nowrap margin-top-20">
                    <div class="row house-users-row align-items-center justify-content-center">
                    @foreach($house->rooms as $room)
                        @foreach($room->acceptedUsers as $user)
                            @if($bedsCount<3 OR $house->beds == 4)
                            <div class="col-auto">
                                <a class="no-style" href="{{$user->profile_url}}" title="{{$user->first_name}} {{$user->last_name}}">
                                    <img src="{{$user->profile_pic}}" alt="{{$user->name}}" class="rounded-circle small-user-pic border-shadow">
                                </a>
                            </div>
                            @endif
                            @php
                                $bedsCount++;   
                            @endphp     
                        @endforeach
                        @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                            @if($bedsCount<3 OR $house->beds == 4)
                            <div class="col-auto">
                                <img class="rounded-circle border-shadow small-user-pic" src="{{url('/images/free-bed.png')}}" alt="Posto libero">
                            </div>
                            @endif
                            @php
                                $bedsCount++; 
                            @endphp    
                        @endfor
                    @endforeach
                    
                    @if($house->beds > 4)
                        <div class="col-auto">
                        <a href="{{$house->url}}" title="Visualizza l'appartamento" target="_blank">
                            <div class="circle more-users border-shadow">
                                + {{$house->beds - 3}}
                            </div>
                        </a>
                        </div>
                    @endif
                    </div>

                </div>
                
                <div class="rooms-container row align-items-center justify-content-center" style="margin-top: 5px">
                @php
                    $bedsCount = 0;
                    $circleWidth = 70;
                @endphp

                @foreach($house->rooms as $room)
                    @if($bedsCount + $room->beds < 4)
                    <div class="col-auto" style="padding: 0px 2px; width: {{($circleWidth)*$room->beds}}px; flex: 0 0 {{($circleWidth)*$room->beds}}px; max-width: {{($circleWidth)*$room->beds}}px;"><div class="room"></div></div>
                    @elseif($bedsCount < 4)
                    <div class="col-auto" style="padding: 0px 2px; width: {{($circleWidth)*(4-$bedsCount)}}px; flex: 0 0 {{($circleWidth)*(4-$bedsCount)}}px; max-width: {{($circleWidth)*(4-$bedsCount)}}px;"><div class="room"></div></div>
                    @endif

                    @php
                    $bedsCount+=$room->beds;
                    @endphp
                @endforeach
                </div><!-- /.row -->

                <div class="house-price margin-top-40 text-right">
                    A partire da <strong class="price">{{$house->minorBedPrice()}}€</strong>
                    <a href="{{$house->url}}" class="btn btn-dark btn-sm margin-left-5">Visualizza L'appartamento</a>
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
    window.location = window.location + "&view=list";
});
</script>
@endsection