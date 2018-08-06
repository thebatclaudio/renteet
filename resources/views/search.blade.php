@extends('layouts.app')

@section('title', 'Be friendly')

@section('content')
<div class="container margin-top-20">
    
    <div class="row">
        <div class="col-auto">
            <h3>Immobili attualmente disponibili nei dintorni di <strong>{{$searchInput}}</strong></h3>
        </div>
        <div class="col text-right">
            <div class="btn-group" role="group" aria-label="Cambia la modalità di visualizzazione degli annunci">
                <a class="btn btn-change-view btn-elegant" title="Visualizzazione a griglia" data-view="grid"><i class="fas fa-th"></i></a>
                <a id="list-view" class="btn btn-change-view btn-outline-elegant" title="Visualizzazione a elenco" data-view="list"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>
    
    <hr>

    <div class="search-results row margin-top-40">
        @forelse($houses as $house)
            @php
                $bedsCount = 0;
            @endphp
        <div class="house-col col-md-4">
            <div id="house-{{$house->id}}" class="house">
                
                <div class="owner-container {{$house->owner->gender}}">
                    <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
                    <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
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
                            @if($bedsCount < 4)
                            <img src="{{$user->profile_pic}}" alt="{{$user->name}}" class="rounded-circle small-user-pic">
                            @endif
                            @php
                                $bedsCount++;   
                            @endphp     
                        @endforeach
                        @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                            @if($bedsCount < 4)
                            <img class="rounded-circle small-user-pic" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Posto libero" width="80" height="80">
                            @endif
                            @php
                                $bedsCount++; 
                            @endphp    
                        @endfor
                    @endforeach
                    
                    @if($house->beds > 4)
                    <div class="container">
                            <a href="{{$house->url}}">
                                <img class="rounded-circle small-user-pic" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Altri posti" width="80" height="80">
                                <div class="centered">+ {{$house->beds - 4}}</div>
                            </a>
                    </div>
                    @endif
                
                </div>

                <div class="house-price margin-top-40 text-right">
                    A partire da <strong class="price">{{$house->minorBedPrice()}}€</strong>
                    <a href="{{$house->url}}" class="btn btn-dark btn-sm margin-left-5">Visualizza L'appartamento</a>
                </div>
            </div>
        </div>
        @empty
            <h4 class="text-muted text-center">Nessuna casa trovata</h4>
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

@section('styles')
<style>
.container {
    position: relative;
    text-align: center;
    display: inline;
}
/* Centered text */
.centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color:whitesmoke;
}
</style>
@endsection