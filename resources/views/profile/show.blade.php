@extends('layouts.app')

@section('title', $user->first_name.' '.$user->last_name)

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container margin-top-20">
    <div class="row">
        <div class="col-md-3">
            <div class="profile-info-column">
                <img src="{{$user->profile_pic}}" class="rounded-circle {{$user->gender}}" height="240" width="240">

                <div class="personal-info-container margin-top-20">
                    <h3 class="profile-name">{{$user->first_name}} {{$user->last_name}}</h3>
                    <ul>
                        <li>{{$user->age}} anni</li>
                        @if($user->livingCity()->count())
                        <li>Vive a <strong>{{$user->livingCity->text}}</strong></li>
                        @endif

                        @if($user->bornCity()->count())
                        <li>Nato a <strong>{{$user->bornCity->text}}</strong></li>
                        @endif

                        @if($user->job)
                        <li>{{$user->job}}</li>
                        @endif

                        @if($user->university)
                        <li>{{$user->university}}</li>
                        @endif
                    </ul>
                </div>

                @if($user->languages()->count())
                <div class="languages-container">
                    <h4>Lingue parlate</h4>
                    <ul class="languages-list">
                    @foreach($user->languages as $language)
                        <li>{{$language->name}}</li>
                    @endforeach
                    <ul>
                </div>                
                @endif

                @if($user->interests()->count())
                <div class="interests-container">
                    <h4>Interessi</h4>
                    <ul class="interests-list">
                    @foreach($user->interests as $interest)
                        <li>#{{$interest->name}}</li>
                    @endforeach
                    <ul>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-5">
            <div class="timeline-column">
                <div class="container text-center h-100">
                    <div class="row h-100">
                        <div class="col-sm-12 my-auto">
                            @if($user->description)
                            <div class="user-description">
                                <h4 class="text-center">
                                {{$user->description}}
                                </h4>
                            </div>
                            <hr>
                            @endif
                            @for($i = 1; $i < 6; $i++)
                                @if($i <= floor($user->rating))
                                    <span class="fas fa-star fa-3x checked"></span>
                                @elseif($i-floor($user->rating) < 0.5)
                                    <span class="far fa-star fa-3x star-border"></span>
                                    <span class="fas fa-star-half fa-3x"></span>
                                @else
                                    <span class="far fa-star fa-3x"></span>
                                @endif
                            @endfor
                            <div class="reviews-users-count">{{$user->reviews()->count()}} Recensioni</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="container timeline-column reviews-column">

                <div class="row">
                    @if($user->lessor)
                    <div id="roommates-button-container" class="col-sm-6 tab-inactive">
                        <button type="button" id="roommates-reviews-button" class="btn btn-block btn-success">Recensioni Coinquilini</button>
                    </div>
                    <div id="guests-button-container" class="col-sm-6 tab-active">
                        <button type="button" id="guests-reviews-button" class="btn btn-block btn-primary">Recensioni Ospiti</button>
                    </div>
                    @else
                    <div class="col-sm-12 tab-active">
                        <button type="button" id="roommates-reviews-button" class="btn btn-block btn-success">Recensioni Coinquilini</button>
                    </div>                    
                    @endif
                </div>

                <div class="row">
                    <div class="col-sm-12 tab-col">
                        <div class="tab-content" id="reviewsTabContent">
                            @if($user->lessor)
                            <div class="tab-pane fade show active" id="guests-tab" role="tabpanel" aria-labelledby="lessor-tab">
                                @forelse ($user->reviews()->where('lessor', true)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                </div>
                                                <div class="col-sm-10">
                                                    <strong class="review-name">{{ $review->fromUser->first_name }} {{ $review->fromUser->last_name }}</strong>
                                                    <span class="review-date">{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p>{{ $review->text }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <strong>{{ $user->first_name }} non ha ancora recensioni come Locatore.</strong>
                                @endforelse
                            </div>
                            <div class="tab-pane fade" id="roommate-tab" role="tabpanel" aria-labelledby="roommate-tab">
                                <ul class="list-group">
                                @forelse ($user->reviews()->where('lessor', false)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                </div>
                                                <div class="col-sm-10">
                                                    <strong class="review-name">{{ $review->fromUser->first_name }} {{ $review->fromUser->last_name }}</strong>
                                                    <span class="review-date">{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p>{{ $review->text }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <strong>{{ $user->first_name }} non ha ancora recensioni come Coinquilino.</strong>
                                @endforelse
                                </ul>
                            </div>
                            @else
                            <div class="tab-pane fade show active" id="roommate-tab" role="tabpanel" aria-labelledby="roommate-tab">
                                <ul class="list-group">
                                @forelse ($user->reviews()->where('lessor', false)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                </div>
                                                <div class="col-sm-10">
                                                    <strong class="review-name">{{ $review->fromUser->first_name }} {{ $review->fromUser->last_name }}</strong>
                                                    <span class="review-date">{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p>{{ $review->text }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <strong>{{ $user->first_name }} non ha ancora recensioni come Coinquilino.</strong>
                                @endforelse
                                </ul>
                            </div>
                            @endif            
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
var roommateTab = $("#roommate-tab");
var guestsTab = $("#guests-tab");
var roommateButtonContainer = $("#roommates-button-container");
var guestsButtonContainer = $("#guests-button-container");

$("#roommates-reviews-button").on('click', function() {
    guestsTab.removeClass('show').removeClass('active');
    roommateTab.addClass('show').addClass('active');
    roommateButtonContainer.removeClass('tab-inactive').addClass('tab-active');
    guestsButtonContainer.addClass('tab-inactive').removeClass('tab-active');
});

$("#guests-reviews-button").on('click', function() {
    roommateTab.removeClass('show').removeClass('active');
    guestsTab.addClass('show').addClass('active');
    guestsButtonContainer.removeClass('tab-inactive').addClass('tab-active');
    roommateButtonContainer.addClass('tab-inactive').removeClass('tab-active');
});
</script>
@endsection