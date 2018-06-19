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
                    <button class="btn btn-block btn-black btn-lg">Recedi dal contratto di locazione</button>
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
    
    <div class="row justify-content-center margin-top-40">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    Chat della casa
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Inserisci qui il messaggio..." aria-label="Inserisci qui il messaggio..." aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button"><i class="fa fa-send"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="d-flex flex-row">
        <form action="{{ route('user.rating') }}" method="post">
            <div class="p-1 text-center">
                {{ csrf_field() }}
                <input type="hidden" name="uid" value="{{ $house->owner_id }}">
                <input type="hidden" id="rating" name="rating" value="">
                <img src="{{ App\User::find($house->owner_id)->profile_pic }}" class="img-circle img-responsive col-md-4"><br>
                <strong>{{ App\User::find($house->owner_id)->first_name }} {{ App\User::find($house->owner_id)->last_name }}</strong> <span class="badge badge-danger">Locatore</span><br>
                <br>
                <div class="review">
                    <div class='circle full' onclick="setRating(this, 1)"></div>
                    <div class='circle full' onclick="setRating(this, 2)"></div>
                    <div class='circle full' onclick="setRating(this, 3)"></div>
                    <div class='circle full' onclick="setRating(this, 4)"></div>
                    <div class='circle full' onclick="setRating(this, 5)"></div>
                </div>
                <br><br>
                <input type="text" name="title" placeholder="Inserisci qui il titolo..." class="form-control"><br>
                <textarea name="message" id="" cols="14" rows="6" placeholder="Inserisci qui il tuo messaggio..." class="form-control"></textarea><br>
                <button type="submit" class="btn btn-lg btn-primary">Recensisci</button>
            </div>
        </form>
        @foreach(App\House::find($house->id)->rooms as $room)
        @foreach(App\RoomUser::where('room_id', $room->id)->where('accepted_by_owner', true)->get() as $room_user)
            <form action="{{ route('user.rating') }}" method="post">
                <div class="p-2 text-center">
                    {{ csrf_field() }}
                    <input type="hidden" name="uid" value="{{ App\User::find($room_user->user_id)->id }}">
                    <input type="hidden" id="rating" name="rating" value="">
                    <img src="{{ App\User::find($room_user->user_id)->profile_pic }}" class="img-circle img-responsive col-md-4"><br>
                    <strong>{{ App\User::find($room_user->user_id)->first_name }} {{ App\User::find($room_user->user_id)->last_name }}</strong><br>
                    <br>
                    <div class="review">
                        <div class='circle full' onclick="setRating(this, 1)"></div>
                        <div class='circle full' onclick="setRating(this, 2)"></div>
                        <div class='circle full' onclick="setRating(this, 3)"></div>
                        <div class='circle full' onclick="setRating(this, 4)"></div>
                        <div class='circle full' onclick="setRating(this, 5)"></div>
                    </div>
                    <br><br>
                    <input type="text" name="title" placeholder="Inserisci qui il titolo..." class="form-control"><br>
                    <textarea name="message" id="" cols="14" rows="6" placeholder="Inserisci qui il tuo messaggio..." class="form-control"></textarea><br>
                    <button type="submit" class="btn btn-lg btn-primary">Recensisci</button>
                </div>
            </form>
            @endforeach
        @endforeach
    </div>
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