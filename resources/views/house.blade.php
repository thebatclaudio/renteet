@extends('layouts.app')

@section('title', 'La tua casa')

@section('styles')
<style>
.preview .first-coloumn {
    padding: 12px;
    max-height: 120px;
}
.preview div[class^=col-md] {
    margin-top: 20px;
}
.avatar {
    margin-top: -20px;
}
.btn{
    white-space:normal !important;
    word-wrap: break-word; 
}
div[class^=circle] {
    background:white;
    border-radius:100%;
    display:inline-block;
    height:20px;
    width:20px;
    overflow:hidden;
    position:relative;
    border: 2px solid orange;
}
div[class^=circle]:after {
    content:'';
    position:absolute;
    display:block;
    height:100%;
    left:0;
    border-radius:100%;
    height:20px;
    width:20px;
}
div.full:hover:after {
    border-radius:100%;
    width:100%;
    background: orange;
}
div.selected {
    border-radius:100%;
    background: orange;
}
</style>
@endsection

@section('content')
<div class="container-fluid preview">
    <div class="row">
        <div class="col-md-2 bg-dark text-white first-coloumn">{{ $house->street_name }}</div>
        <div class="col-md-8">
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
        <div class="col-md-2 bg-dark first-coloumn">
            <img src="{{ App\User::find($house->owner->id)->profile_pic }}" class="avatar img-fluid col-md-11">
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-block btn-danger btn-lg">Recedi dal contratto di locazione</button>
        </div>
        <div class="col-md-2 justify-content-center align-self-center">
            <strong>I tuoi coinquilini</strong>
        </div>
        <div class="col-md-6">
            @foreach(App\House::find($house->id)->rooms as $room)
                @foreach(App\RoomUser::where('room_id', $room->id)->where('accepted_by_owner', true)->get() as $room_user)
                    <img src="{{ App\User::find($room_user->user_id)->profile_pic }}" class="img-circle img-responsive img-thumbnail col-md-2 mx-auto d-block">
                @endforeach
            @endforeach
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-lg btn-outline">Leggi contratto d'affitto</button>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
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