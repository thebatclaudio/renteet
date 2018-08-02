@extends('layouts.app')

@section('title', $user->first_name.' '.$user->last_name)

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container {{$margin}}">

    @if(isset($pendingRequestHouse))
    <div class="pending-request-house">
        <div class="row justify-content-center">
            <div class="card col-md-6">
                <div class="row padding-10">
                    <div class="col-auto">
                        <img src="{{$pendingRequestHouse->preview_image_url}}" alt="{{$pendingRequestHouse->name}}" class="rounded-circle img-fluid margin-top-10" style="max-width:100px;">
                    </div>
                    <div class="col">
                        <h4 class="text-left"><strong>{{$user->first_name}}</strong> ha richiesto di accedere al tuo immobile {{$pendingRequestHouse->name}}</h4>
                        <button id="accept-user" data-room="{{$pendingRequestRoom->id}}" class="btn btn-outline-success waves-effect btn-sm">Accetta la richiesta</button> <a href="{{route('admin.house', $pendingRequestHouse->id)}}" class="btn btn-outline-elegant waves-effect btn-sm">Gestisci immobile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif(isset($livingHouse))
    <div class="living-house">
        <div class="row justify-content-center">
            <div class="card col-md-6">
                <div class="row padding-10">
                    <div class="col-auto">
                        <img src="{{$livingHouse->preview_image_url}}" alt="{{$livingHouse->name}}" class="rounded-circle img-fluid margin-top-10" style="max-width:100px;">
                    </div>
                    <div class="col">
                        <h4 class="text-left"><strong>{{$user->first_name}}</strong> vive nel tuo immobile {{$livingHouse->name}}</h4>
                        <a href="{{route('admin.house', $livingHouse->id)}}" class="btn btn-outline-elegant waves-effect btn-sm">Gestisci il tuo immobile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

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
                @if($user->id == \Auth::user()->id)
                <buttom id="edit-profile-button" class="btn btn-outline-elegant waves-effect btn-lg   margin-top-20">Modifica profilo</buttom>
                @else
                <buttom id="new-message-button" class="btn btn-outline-elegant waves-effect btn-lg   margin-top-20">Invia messaggio</buttom>
                @endif
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
                            <div class="rating-stars-container">
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
                            </div>
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

$("#edit-profile-button").on('click',function(){
    window.location = '{{route('user.edit')}}';
});

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

$("#new-message-button").on('click',function(){
    var messageContainer = document.createElement("form");
    var textArea = document.createElement('textarea');
    textArea.name = 'textareaMessage';
    textArea.id = 'textareaMessage';
    textArea.classList.add('form-control');
    textArea.classList.add('margin-top-40');
    textArea.rows="6"; 
    textArea.placeholder ='Inserisci il testo del messaggio';
    messageContainer.appendChild(textArea);
    
    swal({
            title: "Invia un messaggio a {{$user->first_name}}",
            buttons: [true, {
                text: "Invia",
                className: "nextButtonSwal",
                closeModal: false
            }],
            content: messageContainer
        }).then((send) =>{
            if(!send) throw null;
            if($('#textareaMessage').val() == "") throw null;
            var url = '{{route('chat.newChat', ':id')}}';
            $.post(url.replace(':id','{{$user->id}}'), {message:$('#textareaMessage').val()}, function( data ) {
                if(data.status === 'OK') {
                    swal("Messaggio inviato correttamente", "", "success");
                } else {
                    swal("Si è verificato un errore", "Riprova più tardi", "error");
                }
            });

        })
        .catch((err)=>{
            swal("Si è verificato un errore", "Riprova più tardi", "error");
        });
});
</script>

@include('partials.acceptUser')

@endsection