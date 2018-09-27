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
                        <img src="{{route('house.thumbnail', $pendingRequestHouse->id)}}" alt="{{$pendingRequestHouse->name}}" class="rounded-circle img-fluid margin-top-10" style="max-width:100px;">
                    </div>
                    <div class="col">
                        <h4 class="text-left"><strong>{{$user->first_name}}</strong> ha richiesto di accedere al tuo immobile {{$pendingRequestHouse->name}} il <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d',$pendingRequestRoom->pivot->start)->format('d/m/Y')}}</strong></h4>
                        <button id="accept-user" data-room="{{$pendingRequestRoom->id}}" class="btn btn-outline-success waves-effect btn-sm">Accetta la richiesta</button> <button id="refuse-user" data-room="{{$pendingRequestRoom->id}}" class="btn btn-outline-elegant waves-effect btn-sm">Rifiuta la richiesta</button> <a href="{{route('admin.house', $pendingRequestHouse->id)}}" class="btn btn-outline-primary waves-effect btn-sm">Gestisci immobile</a>
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
                <img src="{{$user->profile_pic}}" class="rounded-circle">

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
                <buttom id="edit-profile-button" class="btn btn-outline-elegant waves-effect btn-sm margin-top-10" style="margin-left: 0px">Modifica profilo</buttom>
                @else
                <buttom id="new-message-button" class="btn btn-outline-elegant waves-effect btn-sm margin-top-10" style="margin-left: 0px">Invia messaggio</buttom>
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
        <div class="col">
            <div class="timeline-column">
                <div class="container text-center h-100">
                    <div class="row h-100">
                        <div class="col-sm-12 my-auto">
                            <div class="rating-stars-container">
                            @for($i = 1; $i < 6; $i++)
                                @if($i <= floor($user->rating))
                                    <span class="fas fa-star checked"></span>
                                @elseif($i-$user->rating < 0.5)
                                    <span class="fas fa-star-half-alt"></span>
                                @else
                                    <span class="far fa-star"></span>
                                @endif
                            @endfor
                            </div>
                            <div class="reviews-users-count">{{$user->reviews()->count()}} Recensioni</div>
                            @if($user->description)
                            <hr>
                            <div class="user-description">
                                <h5 class="text-success">Descrizione</h5>
                                <h4 class="text-center margin-top-10">
                                {{$user->description}}
                                </h4>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="container timeline-column reviews-column">

                <div class="text-center">

                    <h5>Recensioni</h5>

                    @if($user->lessor)
                        <div class="btn-group margin-top-10 margin-bottom-10" role="group" aria-label="Locatore / Ospite">
                            <button id="guests-reviews-button" class="btn btn-sm btn-success">Locatore</button>
                            <button id="roommates-reviews-button" class="btn btn-sm btn-outline-success">Ospite</a>
                        </div>
                    @else
                        <div class="btn-group margin-top-10 margin-bottom-10" role="group" aria-label="Locatore / Ospite">
                            <button id="roommates-reviews-button" class="btn btn-success">Ospite</a>
                        </div>    
                    @endif
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="tab-content" id="reviewsTabContent">
                            @if($user->lessor)
                            <div class="tab-pane fade show active" id="guests-tab" role="tabpanel" aria-labelledby="lessor-tab">
                                <div class="list-group reviews-box">
                                @forelse ($user->reviews()->where('lessor', true)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <a href="{{$review->fromUser->profile_url}}" title="{{$review->fromUser->complete_name}}">
                                                        <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                    </a>
                                                </div>
                                                <div class="col text-center">
                                                    <p>{{ $review->text }}</p>
                                                    <div class="review-rating">
                                                    @for($i = 1; $i < 6; $i++)
                                                        @if($i <= ($review->rate))
                                                            <span class="fas fa-star checked"></span>
                                                        @else
                                                            <span class="far fa-star"></span>
                                                        @endif
                                                    @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center"><strong>{{ $user->first_name }} non ha ancora recensioni come Locatore.</strong></div>
                                @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="roommate-tab" role="tabpanel" aria-labelledby="roommate-tab">
                                <div class="list-group reviews-box">
                                @forelse ($user->reviews()->where('lessor', false)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-auto text-center">
                                                    <a href="{{$review->fromUser->profile_url}}" title="{{$review->fromUser->complete_name}}">
                                                        <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                    </a>
                                                    <br/>
                                                    @if($review->tenant)
                                                        <span class="badge elegant-color"><small>Locatore</small></span>
                                                    @endif
                                                </div>
                                                <div class="col text-center">
                                                    <p>{{ $review->text }}</p>
                                                    <div class="review-rating">
                                                    @for($i = 1; $i < 6; $i++)
                                                        @if($i <= ($review->rate))
                                                            <span class="fas fa-star checked"></span>
                                                        @else
                                                            <span class="far fa-star"></span>
                                                        @endif
                                                    @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center"><strong>{{ $user->first_name }} non ha ancora recensioni come Coinquilino.</strong></div>
                                @endforelse
                                </div>
                            </div>
                            @else
                            <div class="tab-pane fade show active" id="roommate-tab" role="tabpanel" aria-labelledby="roommate-tab">
                                <div class="list-group reviews-box">
                                @forelse ($user->reviews()->where('lessor', false)->get() as $review)
                                    <div class="review">
                                        <div class="speech-bubble">
                                            <div class="row">
                                                <div class="col-auto text-center">
                                                    <a href="{{$review->fromUser->profile_url}}" title="{{$review->fromUser->complete_name}}">
                                                        <img src="{{ $review->fromUser->profile_pic }}" class="rounded-circle avatar">
                                                    </a>
                                                    <br/>
                                                    @if($review->tenant)
                                                        <span class="badge elegant-color"><small>Locatore</small></span>
                                                    @endif
                                                </div>
                                                <div class="col text-center">
                                                    <p>{{ $review->text }}</p>
                                                    <div class="review-rating">
                                                    @for($i = 1; $i < 6; $i++)
                                                        @if($i <= ($review->rate))
                                                            <span class="fas fa-star checked"></span>
                                                        @else
                                                            <span class="far fa-star"></span>
                                                        @endif
                                                    @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center"><strong>{{ $user->first_name }} non ha ancora recensioni come Coinquilino.</strong></div>
                                @endforelse
                                </div>
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
var guestsButton = $("#guests-reviews-button");
var roommateButton = $("#roommates-reviews-button");

$("#edit-profile-button").on('click',function(){
    window.location = '{{route('user.edit')}}';
});

roommateButton.on('click', function() {
    guestsTab.removeClass('show').removeClass('active');
    roommateTab.addClass('show').addClass('active');
    roommateButton.removeClass('btn-outline-success').addClass('btn-success');
    guestsButton.addClass('btn-outline-success').removeClass('btn-success');
});

guestsButton.on('click', function() {
    roommateTab.removeClass('show').removeClass('active');
    guestsTab.addClass('show').addClass('active');
    guestsButton.removeClass('btn-outline-success').addClass('btn-success');
    roommateButton.addClass('btn-outline-success').removeClass('btn-success');
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