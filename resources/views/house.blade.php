@extends('layouts.app')

@section('title', 'La tua casa')

@section('styles')
<link rel="stylesheet" href="/css/myhouse.css?{{rand()}}">
@endsection

@section('content')
<div class="container-fluid preview">
    <div class="row">
        <div class="col-md-2 bg-dark text-white first-column">
            <h4>{{$house->name}}</h4>
            <ul class="list-unstyled">
                <li>{{ $house->street_name }} {{ $house->number }}</li>
                <li>{{ $house->city }}</li>
            </ul>
        </div>
        <div class="col-md-8 no-padding">
            <div id="demo" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                </ul>
                
                <div class="carousel-inner">
                    @foreach($house->photos as $photo)
                        @if ($loop->first)
                          <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
                        @else
                          <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
                        @endif
                    @endforeach
                </div>
                
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>                    
            </div>
        </div>
        <div class="col-md-2 bg-dark last-column">
            <img src="{{ $house->owner->profile_pic }}" class="avatar img-fluid">
            <h6 class="text-center margin-top-40">Locatore</h6>
            <h5 class="text-center">{{$house->owner->first_name}} {{$house->owner->last_name}}</h5>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="align-vertical-center">
                <div>
                    <button class="btn btn-block btn-success btn-lg">Leggi contratto d'affitto</button>
                </div>
                <div class="margin-top-10">
                    <button class="btn btn-block btn-elegant btn-lg">Recedi dal contratto di locazione</button>
                </div>
            </div>
        </div>
        <div class="col-md-2 text-right border-left">
            <div class="align-vertical-center">
                <h4>I tuoi coinquilini:</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            @foreach($house->rooms as $room)

                @foreach($room->acceptedUsers as $user)
                    <div class="col">
                        <a href="{{ $user->profile_url }}" title="{{ $user->complete_name }}">
                            <img src="{{ $user->profile_pic }}" class="img-fluid rounded-circle roommate-img {{\Auth::user()->gender}}">
                            <h6 class="roommate-name text-center text-nowrap {{\Auth::user()->gender}} margin-top-10">{{$user->complete_name}}</h6>
                        </a>
                    </div>
                @endforeach

                @for($i = 0; $i < $room->beds - $room->acceptedUsers()->count(); $i++)
                    <div class="col">
                        <img src="/images/empty-place.png" class="img-fluid rounded-circle roommate-img empty-place {{\Auth::user()->gender}}">
                    </div>
                @endfor

            @endforeach
            </div>
        </div>
    </div>

    <hr class="margin-top-40">
    
</div>
@endsection

@section('scripts')
<script>
function setRating(element, value) {
    document.getElementById('rating').value = value;
    element.classList.add('selected');
}
</script>
@endsection