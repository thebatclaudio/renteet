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
</style>
@endsection

@section('content')
<div class="container-fluid preview">
    <div class="row">
        <div class="col-md-2 bg-dark text-white first-column">
            <h4>{{$house->name}}</h4>
            <ul class="list-unstyled">
                <li>{{ $house->street_name }} {{ $house->number }}</li>
                <li>{{ $house->city }}</li>
            </ul>
        </div>
        <div class="col-md-8 no-padding">
            <div id="homeCarousel" class="carousel slide" data-ride="carousel">
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
                          <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
                        @else
                          <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
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
        <div class="col-md-2 bg-dark last-column">
            <a href="{{$house->owner->profile_url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                <img src="{{ $house->owner->profile_pic }}" class="avatar img-fluid">
            </a>
            <h6 class="text-center margin-top-40">Locatore</h6>
            <h5 class="text-center">{{$house->owner->first_name}} {{$house->owner->last_name}}</h5>
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
                    <div class="col text-center" style="max-width:30%;">
                        <a href="{{ $user->profile_url }}" title="{{ $user->complete_name }}">
                            <img src="{{ $user->profile_pic }}" class="img-fluid rounded-circle roommate-img {{\Auth::user()->gender}}">
                            <h6 class="roommate-name text-center text-nowrap {{\Auth::user()->gender}} margin-top-10">{{$user->first_name}}</h6>
                        </a>
                    </div>
                @endforeach

                @for($i = 0; $i < $room->beds - $room->acceptedUsers()->count(); $i++)
                    <div class="col">
                        <img src="/images/empty-place.png" class="img-fluid rounded-circle roommate-img empty-place {{\Auth::user()->gender}}">
                    </div>
                @endfor

            @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-between margin-top-40">
        <div class="col-auto">
            <button class="btn btn-block btn-outline-elegant waves-effect btn-lg" id="reviewButton">Recensisci</button> 
        </div>
        <div class="col-auto">
            <button class="btn btn-block btn-outline-elegant waves-effect btn-lg">Vai alla chat della casa</button> 
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

    var radioContainer = document.createElement("div");
        radioContainer.classList.add("row");
    var col = document.createElement("div");
        col.classList.add("col");
    var label = document.createElement("label");
    var input = document.createElement("input");
        input.type = "radio";
        input.name = "type";
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
            var col = document.createElement("div");
            col.classList.add("col");
            var label = document.createElement("label");
            var input = document.createElement("input");
            input.type = "radio";
            input.name = "type";
            input.value = "{{$user->id}}";
            var image = document.createElement("img");
            image.src = "{{$user->profile_pic}}";
            image.classList.add("img-fluid"); 
            image.classList.add("rounded-circle");
            label.appendChild(input);
            label.appendChild(image);
            col.appendChild(label);
            radioContainer.appendChild(col);
            @endforeach
        @endforeach

    swal({
          title: "Inserisci la data in cui abbandonerai l'immobile",
          buttons: [true, {
            text: "Abbandona l'immobile",
            closeModal: false
          }],
          content: radioContainer
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection