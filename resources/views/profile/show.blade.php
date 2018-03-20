@extends('layouts.app')

@section('title', $user->first_name.' '.$user->last_name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="profile-info-column">
                <img src="{{$user->profile_pic}}" class="rounded-circle {{$user->gender}}" height="120" width="120">

                <ul class="list-group margin-top-20">
                    <li class="list-group-item">{{$user->first_name}} {{$user->last_name}}</li>
                    <li class="list-group-item">Nato il <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d', $user->birthday)->format('d M Y')}}</strong></li>
                    <li class="list-group-item">Vive a <strong>{{$user->living_city}}</strong></li>
                    <li class="list-group-item">Nato a <strong>{{$user->born_city}}</strong></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="timeline-column">
            </div>
        </div>
    </div>
</div>
@endsection