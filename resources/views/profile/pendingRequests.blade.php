@extends('layouts.app')

@section('title', "Richieste di adesione in sospeso")

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container margin-top-120">
    <div class="page-title-container">
        <h2 class="page-title">Richieste di adesione inviate in sospeso</h1>   
    </div>

    @foreach($requests as $request)
        <a href="{{$request->house->url}}" title="{{'Visualizza la casa'}}" class="notification-link">
            <div class="card shadow margin-top-40">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-1">
                            <img class="profile-pic img-fluid" src="{{$request->house->preview_image_url}}">
                        </div>
                        <div class="col-sm-11">
                            <h5 class="margin-top-10">{{$request->house->name}}</h5> 
                            <small class="notification-date">Inviata <strong class="date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->pivot->created_at)->timestamp}}000</strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    moment.locale('it');
    $(".date").each(function() {
        console.log()
        $(this).text(moment.utc($(this).text(), 'x').fromNow());
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection