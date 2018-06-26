@extends('layouts.app')

@section('title', "Notifiche")

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container margin-top-120">
    <div class="page-title-container">
        <h2 class="page-title">Notifiche</h1>   
    </div>

    @foreach($notifications as $notification)
        <a href="{{$notification->url}}" title="{{'Visualizza la notifica'}}" class="notification-link">
            <div class="card shadow margin-top-40">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-1">
                            <img class="profile-pic img-fluid" src="{{$notification->image}}">
                        </div>
                        <div class="col-sm-11">
                            <h5 class="margin-top-10">{{$notification->user->first_name}}{{$notification->user->last_name}}</h5> 
                            <small class="notification-date">{{$notification->date}}</small>
                        </div>
                    </div>
                    <p class="margin-top-20">{{$notification->text}}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection