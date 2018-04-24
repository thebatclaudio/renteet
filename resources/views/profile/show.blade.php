@extends('layouts.app')

@section('title', $user->first_name.' '.$user->last_name)
<style>
.reviews-column .list-group-item {
    background: none;
    border: 0;
}
.reviews-column .nav-tabs {
    border: 0;
}
.reviews-column .nav-link {
    border-radius: .25rem;
}
.speech-bubble { 
    position: relative; 
    background: white; 
    border-radius: .4em; 
    float: right;
    width: 80%;
    color: black;
    padding: 8px;
}
.speech-bubble:after { 
    content: ''; 
    position: absolute; 
    left: 0; 
    top: 50%; 
    width: 0; 
    height: 0; 
    border: 20px solid transparent; 
    border-right-color: white; 
    border-left: 0; 
    border-bottom: 0; 
    margin-top: -10px; 
    margin-left: -20px; 
}
.speech-bubble-right { 
    position: relative; 
    background: #0093bb; 
    border-radius: .4em; 
    float: left;
    width: 80%;
    color: white;
    padding: 8px;
}
.speech-bubble-right:after { 
    content: ''; 
    position: absolute; 
    right: 0; 
    top: 50%; 
    width: 0; 
    height: 0;
    border: 20px solid transparent;
    border-left-color: #0093bb;
    border-right: 0;
    border-bottom: 0;
    margin-top: -10px; 
    margin-right: -20px; 
}
.avatar {
    width: 48px;
    float: left;
    vertical-align: middle;
    margin-top: 10px;
    z-index: 999;
    position: absolute;
}
.avatar-right {
    float: right !important;
    margin-top: unset;
    margin-left: 16px !important;
}
</style>
@section('styles')

@endsection

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

                <div class="interests-container">
                    <h4>Interessi</h4>
                    <ul class="interests-list">
                    @foreach($user->interests as $interest)
                        <li>#{{$interest->name}}</li>
                    @endforeach
                    <ul>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="timeline-column">

            </div>
        </div>
        <div class="col-md-4">
            <div class="timeline-column reviews-column">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if($user->lessor)
                    <li class="nav-item">
                        <a class="nav-link active" id="lessor-tab" data-toggle="tab" href="#lessor" role="tab" aria-controls="lessor" aria-selected="true">Ospiti</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="roommate-tab" data-toggle="tab" href="#roommate" role="tab" aria-controls="roommate" aria-selected="false">Coinquilini</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="lessor" role="tabpanel" aria-labelledby="lessor-tab">
                        <ul class="list-group">
                        @forelse (App\Review::where('to_user_id', $user->id)->where('lessor', true)->cursor() as $review)
                            <li class="list-group-item">
                                <div class="speech-bubble">{{ $review->text }}</div>
                                <img src="{{ App\User::find($review->from_user_id)->profile_pic }}" class="rounded-circle avatar">
                            </li>
                        @empty
                            <strong>{{ $user->first_name }} non ha ancora recensioni come Locatore.</strong>
                        @endforelse
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="roommate" role="tabpanel" aria-labelledby="roommate-tab">
                        <ul class="list-group">
                        @forelse (App\Review::where('to_user_id', $user->id)->where('lessor', false)->cursor() as $review)
                            @if($loop->iteration  % 2 == 0)
                                <li class="list-group-item">
                                    <div class="speech-bubble-right">{{ $review->text }}</div>
                                    <img src="{{ App\User::find($review->to_user_id)->profile_pic }}" class="rounded-circle avatar avatar-right">
                                </li>
                            @else
                                <li class="list-group-item">
                                    <img src="{{ App\User::find($review->from_user_id)->profile_pic }}" class="rounded-circle avatar">
                                    <div class="speech-bubble">{{ $review->text }}</div>
                                </li>
                            @endif
                        @empty
                            <strong>{{ $user->first_name }} non ha ancora recensioni come Locatore.</strong>
                        @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection