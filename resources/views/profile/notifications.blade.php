@extends('layouts.app')

@section('title', "Notifiche")

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="page-target-container margin-top-40">
            <h3 class="page-target">Le tue notifiche</h3>
        </div>
    </div>

    <div class="margin-top-120">
        @foreach($notifications as $notification)
            <a href="{{$notification->url}}" title="{{'Visualizza la notifica'}}" class="notification-link">
                <div class="card shadow margin-top-40 col-sm-8">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <img class="img-fluid rounded-circle" src="{{$notification->image}}" width="80" height="80">
                            </div>
                            <div class="col">
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
</div>
@endsection