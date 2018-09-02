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
    border:5px solid transparent;
}
label > input:checked + img {
    border: 5px solid #619bd5;
}
label > input:checked ~ p {
    color: #619bd5;
    font-weight: 800;
}
textarea{
    resize:none;
}
</style>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="house-info-col col-md-3 margin-top-40">
            <div class="card">
                <div class="card-body text-dark text-center">
                    <h5>{{$house->name}}</h5>
                    <p class="card-text text-center">{{ $house->street_name }} {{ $house->number }} - {{ $house->city }}</p>
                    <div class="text-center margin-top-40">
                        <a href="{{$house->owner->profile_url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                            <img src="{{ $house->owner->profile_pic }}" class="img-fluid rounded-circle" style="max-width:150px;" alt="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                        </a>
                        <h6 style="font-size: 16px;margin-top: 10px;">{{$house->owner->complete_name}}</h6>
                        <h6 style="font-size: 12px;">PROPRIETARIO</h6>
                    </div>
                </div>
            </div>

            <a href="{{route('chat.show')}}" class="btn btn-block btn-outline-elegant waves-effect btn-lg">Vai alla chat della casa</a> 
            <button class="btn btn-block btn-outline-elegant waves-effect btn-lg" id="reviewButton">Lascia una recensione</button> 
            <!--button class="btn btn-block btn-outline-elegant waves-effect btn-lg">Leggi contratto d'affitto</button--> 
            @if(!$exited)
                <button class="btn btn-block btn-elegant btn-lg" id="exitButton">Abbandona l'immobile</button>
            @else
                <button class="btn btn-block btn-elegant btn-lg" disabled>Abbandonerai l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d', $exited)->format('d/m/Y')}}</button>
            @endif
        </div>
        <div class="col-md-9 margin-top-40 no-padding align-self-start">
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
                          <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name."-1920.jpg")}})"></div>
                        @else
                          <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name."-1920.jpg")}})"></div>
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
    
</div>
@endsection

@section('scripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// * SWAL PER ABBANDONO * //

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

          var url = '{{route('ajax.exit.room', $room_id)}}';
          $.post(url, { stopDate: select.val() }, function( data ) {
            if(data.status === 'OK') {
              swal("Operazione riuscita", "Invia un messaggio al locatore e organizzatevi per il checkout", "success").then(() => { location.reload() });
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


// * SWAL PER RECENSIONI * //

$('#reviewButton').on('click',function(){

    // creo il radio container con utenti e casa da poter recensire
    var radioContainer = document.createElement("form");
        radioContainer.classList.add("row");
        radioContainer.id = 'radioForm';

    // aggiungo il primo elemento del radio relativo alla casa
    var col = document.createElement("div");
        col.classList.add("col");
    var label = document.createElement("label");
    var input = document.createElement("input");
        input.type = "radio";
        input.name = "type";
        input.classList.add("radioReview");
        input.value = "house";
        input.dataset.name = "{{$house->name}}";
    var image = document.createElement("img");
        image.src = "{{$house->preview_image_url}}";
        image.classList.add("img-fluid"); 
        image.classList.add("rounded-circle");
    var pName = document.createElement("p");
        pName.innerText = "{!! $house->name !!}";
        pName.classList.add("margin-top-10");
        label.appendChild(input);
        label.appendChild(image);
        label.appendChild(pName);
        col.appendChild(label);
        radioContainer.appendChild(col);

    // ciclo i coinquilini e creo un elemento del radio input per ognuno di loro
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
                input.dataset.name = "{{$user->complete_name}}";
                var image = document.createElement("img");
                image.src = "{{$user->profile_pic}}";
                image.classList.add("img-fluid"); 
                image.classList.add("rounded-circle");
                var pName = document.createElement("p");
                pName.innerText = "{!! $user->complete_name !!}";
                pName.classList.add("margin-top-10");
                label.appendChild(input);
                label.appendChild(image);
                label.appendChild(pName);
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
          content: radioContainer // aggiungo il radio container creato precedentemente
        })
        .then((send) => {
            var formVal = $('input[name=type]:checked','#radioForm').val();
            var name = $('input[name=type]:checked','#radioForm').data("name");
            if (!send || !formVal) throw null;

            // se è stato selezionato un elemento allora lancio un'altra swal per il contenuto della recensione
            swal({
                title: "Recensisci "+name,
                buttons: [true, {
                    text: "Avanti",
                    className: "nextButtonSwal",
                    closeModal: false
                }],
                content: ratingSystem((formVal == 'house'))
            }).then((send) =>{
                if(!send) throw null;
                if(!$('#hiddenInputStar').val() || !$('#textareaReview').val() || $('#textareaReview').val() == "") throw 'MISSING_DATA';

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
                if(err) {
                    if(err === 'MISSING_DATA') {
                        swal("Dati mancanti", "Completa tutti i dati per poter inserire la recensione", "error");
                    } else {
                        swal("Si è verificato un errore", "Riprova più tardi", "error");
                    }
                }
            });

            $('.nextButtonSwal').attr('disabled',true);
        })
        .catch(err => {
            if(err) swal("Si è verificato un errore", "Riprova più tardi", "error");
        });

        $('.nextButtonSwal').attr('disabled',true);

        $('.radioReview').on('change',function(){
            $('.nextButtonSwal').attr('disabled',false);
        });
});

function ratingSystem(isHouse){
    var starsContainer = document.createElement("form");
    starsContainer.classList.add('rating-stars-container');

    // Se sto recensendo la casa allora inserisco il messaggio
    if(isHouse) {
        var message = document.createElement("p");
        message.innerText = "Nella tua recensione ricordati di valutare anche il rapporto avuto con il locatore";
        message.classList.add("margin-top-20");
        message.classList.add("margin-bottom-20");
        starsContainer.appendChild(message);
    }

    for(i = 0; i < 5; i++){
        var star = document.createElement("i");
        star.classList.add('far');
        star.classList.add('fa-star');
        star.classList.add('rating-star');
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

$('body').on('click','.rating-star',function(){
    var rating = $(this).data('rate');
    $('#hiddenInputStar').val(rating);
    $('.rating-star').removeClass('checked').removeClass('fas').addClass('far');
    
    for(i = 0; i<=rating;i++){
        $('#star-'+i).addClass('checked').removeClass('far').addClass('fas');
    }

    if($("#textareaReview").val() && $("#textareaReview").val() != "") {
        $('.nextButtonSwal').attr('disabled',false);
    }
});

$('body').on('keyup','#textareaReview',function(){
    if($('#hiddenInputStar').val() && $('#hiddenInputStar').val != "" && $("#textareaReview").val() && $("#textareaReview").val() != "") {
        $('.nextButtonSwal').attr('disabled',false);
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection