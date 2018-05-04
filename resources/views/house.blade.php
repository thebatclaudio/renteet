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
    </div>
</div>
@endsection
