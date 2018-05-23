@extends('layouts.app')

@section('title', 'Be friendly')

@section('content')
<div class="container-fluid margin-top-20">
    <h5 class="page-title">Case nei dintorni di:<h5>
    <h3 class="page-title">{{$searchInput}}</h3>

    <div class="search-results row margin-top-40">
        @forelse($houses as $house)
        <div class="col-md-4">
            <div class="card margin-top-20">
                <div id="house-{{$house->id}}-carousel" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach($house->photos as $photo)
                            @if ($loop->first)
                            <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
                            @else
                            <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#house-{{$house->id}}-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#house-{{$house->id}}-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><strong>{{$house->name}}</strong> <small>{{$house->street_name}}, {{$house->number}}</small></h5>
                    <div class="house-users margin-top-20">
                    @foreach($house->rooms as $room)
                        @foreach($room->acceptedUsers as $user)
                            <img src="{{$user->profile_pic}}" alt="{{$user->name}}" class="rounded-circle small-user-pic">
                        @endforeach
                        @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                            <img class="rounded-circle small-user-pic" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Posto libero" width="80" height="80">
                        @endfor
                    @endforeach
                    </div>
                    <div class="actions margin-top-20">
                        <a href="{{$house->url}}" class="btn btn-primary pull-right">Visualizza &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <h4 class="text-muted text-center">Nessuna casa trovata</h4>
        @endforelse
    </div>
</div>
@endsection
