@extends('layouts.app')

@section('title', 'La tua casa')

@section('styles')
<link rel="stylesheet" href="/css/myhouse.css?{{rand()}}">
<style>
label > input{ /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
  border:2px solid #f00;
}
textarea{
    resize:none;
}
</style>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 margin-top-20 align-self-center">
            <div class="card" style="max-width: 18rem;">
                <div class="card-body text-dark text-center">
                    <h5>{{$house->name}}</h5>
                    <p class="card-text text-center">{{ $house->city }},{{ $house->street_name }} {{ $house->number }}</p>
                    <div class="text-center margin-top-40">
                        <a href="{{$house->owner->profile_url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                            <img src="{{ $house->owner->profile_pic }}" class="img-fluid rounded-circle" style="max-width:150px;" alt="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                        </a>
                        <h6 style="font-size: 16px;margin-top: 10px;">{{$house->owner->complete_name}}</h6>
                        <h6 style="font-size: 12px;">PROPRIETARIO</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 margin-top-40 no-padding align-self-start">
            <div class="col-md-5 margin-bottom-10 float-right">
                <a href="{{route('chat.show')}}" class="btn btn-block btn-outline-success waves-effect btn-lg">Vai alla chat della casa</a> 
            </div>
            <div id="homeCarousel" class="carousel slide padding-right-10" data-ride="carousel">
                <ul class="carousel-indicators">
                    @for($i = 0; $i < $house->photos()->count(); $i++)
                        @if($i == 0)
                            <li data-target="#homeCarousel" data-slide-to="{{$i}}" class="active"></li>
                        @else
                            <li data-target="#homeCarousel" data-slide-to="{{$i}}"></li>
                        @endif
                    @endfor
                </ul>
                
                <div class="carousel-inner">
                    @foreach($house->photos as $photo)
                        @if ($loop->first)
                          <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($photo->file_name))}}); max-height:50%;"></div>
                        @else
                          <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($photo->file_name))}}); max-height:50%;"></div>
                        @endif
                    @endforeach
                </div>
                
                <a class="carousel-control-prev" href="#homeCarousel" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#homeCarousel" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>                    
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3 padding-right-30">
            <div class="align-vertical-center">
                <button class="btn btn-block btn-elegant btn-lg" id="exitButton">Abbandona l'immobile</button>    
            </div>
        </div>
        <div class="col-md-2 text-right border-left">
            <div class="align-vertical-center">
                <h5>I tuoi coinquilini:</h5>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            @foreach($house->rooms as $room)

                @foreach($room->acceptedUsers as $user)
                    @if($user->id != \Auth::user()->id)
                        <div class="col text-center" style="max-width:30%;">
                            <a href="{{ $user->profile_url }}" title="{{ $user->complete_name }}">
                                <img src="{{ $user->profile_pic }}" class="img-fluid rounded-circle roommate-img {{\Auth::user()->gender}}">
                                <h6 class="roommate-name text-center text-nowrap {{\Auth::user()->gender}} margin-top-10">{{$user->first_name}}</h6>
                            </a>
                        </div>
                    @endif
                @endforeach

            @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-between margin-top-40">
        <div class="col-auto">
            <button class="btn btn-block btn-outline-elegant waves-effect btn-lg">Leggi contratto d'affitto</button> 
        </div>
        <div class="col-auto">
            <button class="btn btn-block btn-outline-elegant waves-effect btn-lg" id="reviewButton">Lascia una recensione</button> 
        </div>
    </div>

    <hr class="margin-top-40">
    
</div>
@endsection

@section('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#reviewButton').on('click',function(){

    var radioContainer = document.createElement("form");
        radioContainer.classList.add("row");
        radioContainer.id = 'radioForm';
    var col = document.createElement("div");
        col.classList.add("col");
    var label = document.createElement("label");
    var input = document.createElement("input");
        input.type = "radio";
        input.name = "type";
        input.classList.add("radioReview");
        input.value = "house";
    var image = document.createElement("img");
        image.src = "{{$house->preview_image_url}}";
        image.classList.add("img-fluid"); 
        image.classList.add("rounded-circle");
        label.appendChild(input);
        label.appendChild(image);
        col.appendChild(label);
        radioContainer.appendChild(col);

        @foreach($house->rooms as $room)
            @foreach($room->acceptedUsers as $user)
                @if($user->id !== \Auth::user()->id)
                    var col = document.createElement("div");
                    col.classList.add("col");
                    var label = document.createElement("label");
                    var input = document.createElement("input");
                    input.type = "radio";
                    input.name = "type";
                    input.classList.add("radioReview");
                    input.value = "{{$user->id}}";
                    var image = document.createElement("img");
                    image.src = "{{$user->profile_pic}}";
                    image.classList.add("img-fluid"); 
                    image.classList.add("rounded-circle");
                    label.appendChild(input);
                    label.appendChild(image);
                    col.appendChild(label);
                    radioContainer.appendChild(col);
                @endif
            @endforeach
        @endforeach

    swal({
          title: "Chi vuoi recensire?",
          buttons: [true, {
            text: "Avanti",
            className: "nextButtonSwal",
            closeModal: false
          }],
          content: radioContainer
        })
        .then((send) => {

            if (!send) throw null;
            var formVal = $('input[name=type]:checked','#radioForm').val();
            if(!formVal) throw null;
            swal({
                title: "Chi vuoi recensire?",
                buttons: [true, {
                    text: "Avanti",
                    className: "nextButtonSwal",
                    closeModal: false
                }],
                content: ratingSystem()
            }).then((send) =>{
                if(!send) throw null;
                var url = '{{route('user.rate', ':id')}}';
                $.post(url.replace(':id',formVal), { rating: $('#hiddenInputStar').val(),message:$('#textareaReview').val(),room_user_id:{{$room_user_id}}}, function( data ) {
                    if(data.status === 'OK') {
                        swal("Recensione inserita correttamente", "", "success");
                    } else {
                        swal("Si è verificato un errore", "Riprova più tardi", "error");
                    }
                });

            })
            .catch((err)=>{
                swal("Si è verificato un errore", "Riprova più tardi", "error");
            });
        })
        .catch(err => {
            swal("Si è verificato un errore", "Riprova più tardi", "error");
        });
        $('.nextButtonSwal').attr('disabled',true);
        $('.radioReview').on('change',function(){
            $('.nextButtonSwal').attr('disabled',false);
        });
});

$("#exitButton").on('click', function () {

    var dateSelect = document.createElement("select");
        dateSelect.classList.add("form-control");
        dateSelect.id = "stop-date";

        moment.locale('it');

        option = document.createElement('option');
        option.value = -1;
        option.textContent =  "Seleziona una data";
        option.disabled = true;
        option.selected = true;
        dateSelect.appendChild( option );

        var date = moment().subtract(1, 'days');
        for(var i = 0; i < 90; i++) {
          date.add(1, 'days');
          option = document.createElement('option');
          option.value = date.format("YYYY-MM-DD");
          option.textContent =  date.format("D MMMM");
          dateSelect.appendChild( option );
        }

        swal({
          title: "Inserisci la data in cui abbandonerai l'immobile",
          buttons: [true, {
            text: "Abbandona l'immobile",
            closeModal: false
          }],
          content: dateSelect
        })
        .then((send) => {

          if (!send) throw null;

          var select = $("#stop-date");

          if(select.val() === null || select.val() === -1) throw 'MISSING_DATE';

          var url = '{{route('ajax.exit.room', $user->livingRooms()->first()->id)}}';
          $.post(url, { stopDate: select.val() }, function( data ) {
            if(data.status === 'OK') {
              swal("Operazione riuscita", "Invia un messaggio al locatore e organizzatevi per il checkout", "success");
            } else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
          });
        })
        .catch(err => {
          if (err) {
            if(err === 'MISSING_DATE') {
              swal("Inserisci la data in cui abbandonerai l'immobile", "", "error");
            } else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
          } else {
            swal.stopLoading();
            swal.close();
          }
        });
});

function ratingSystem(){
    var starsContainer = document.createElement("form");
    starsContainer.classList.add('rating-stars-container');
    for(i = 0; i < 5; i++){
        var star = document.createElement("i");
        star.classList.add('icon');
        star.classList.add('icon-circle-empty');
        star.classList.add('ratingStar');
        star.dataset.rate = i;
        star.id = 'star-'+i;
        starsContainer.appendChild(star);
    };
    var inputStar = document.createElement('input');
    inputStar.type = 'hidden';
    inputStar.id = 'hiddenInputStar';
    
    var textArea = document.createElement('textarea');
    textArea.name = 'textareaReview';
    textArea.id = 'textareaReview';
    textArea.classList.add('form-control');
    textArea.classList.add('margin-top-40');
    textArea.rows="6"; 
    textArea.placeholder ='Lascia qui una recensione';
    starsContainer.appendChild(inputStar);
    starsContainer.appendChild(textArea);
    
    return starsContainer;
}

$('body').on('click','.ratingStar',function(){
    var rating = $(this).data('rate');
    $('#hiddenInputStar').val(rating);
    $('.ratingStar').removeClass('icon-circle-full').addClass('icon-circle-empty');
    
    for(i = 0; i<=rating;i++){
        $('#star-'+i).removeClass('icon-circle-empty').addClass('icon-circle-full');
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection