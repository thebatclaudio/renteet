@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Casa</div>

        <div class="panel-body">
            <h2>{{$house->name}}</h2>
            <hr>
            <div class="rooms-list row">
                @foreach($house->rooms as $index => $room)
                <div class="col-md-12">
                    <div class="room-el margin-top-20">
                        <div class="card-block">
                            <h4 class="card-title">Stanza {{$index+1}} <i class="fa fa-bed"></i> x {{$room->beds}}</h4>
                            <hr>
                            <h5>Inquilini</h5>
                                @forelse($room->users as $user)
                                @if(!$user->pivot->accepted_by_owner)
                                    <div class="card margin-top-20 col-md-6">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="{{$user->profile_url}}"><img src="{{$user->profile_pic}}" class="rounded-circle img-fluid"></a>
                                                </div>
                                                <div class="col-sm-9 padding-left-20">
                                                    <h5 class="mb-1 margin-top-10">{{$user->first_name}} {{$user->last_name}} inizierà il soggiorno il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->start)->format('d/m/Y')}}</h5>
                                                    <button class="btn btn-success btn-sm accept-user" data-user="{{$user->id}}" data-room="{{$room->id}}">Accetta</button>
                                                    <button class="btn btn-elegant btn-sm refuse-user" data-user="{{$user->id}}" data-room="{{$room->id}}">Rifiuta</button>
                                                    <small class="margin-left-20">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user->pivot->created_at)->format('d/m/Y')}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($user->pivot->stop === null)

                                <div class="card margin-top-20 col-md-6">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="{{$user->profile_url}}"><img src="{{$user->profile_pic}}" class="rounded-circle img-fluid"></a>
                                                </div>
                                                <div class="col-sm-9 padding-left-20">
                                                    <h5>Attuale inquilino</h5>
                                                    <h3 class="mb-1 margin-top-10">{{$user->first_name}} {{$user->last_name}}</h3>
                                                    <button class="btn btn-elegant btn-sm remove-user pull-right" data-user="{{$user->id}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->start}}">Rimuovi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif($user->pivot->stop !== null && $user->pivot->available_from === null)
                                <div class="card margin-top-20 col-md-6">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="{{$user->profile_url}}"><img src="{{$user->profile_pic}}" class="rounded-circle img-fluid"></a>
                                                </div>
                                                <div class="col-sm-9 padding-left-20">
                                                    @if(\Carbon\Carbon::now()->format('Y-m-d') < $user->pivot->stop)
                                                        <h3 class="mb-1 margin-top-10">{{$user->first_name}} {{$user->last_name}} abbandoner&agrave; l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</h3>
                                                    @else
                                                        <h3 class="mb-1 margin-top-10">{{$user->first_name}} {{$user->last_name}} ha abbandonato l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</h3>
                                                    @endif
                                                    <p>Quando vuoi che la stanza torni disponibile?</p>
                                                    <button class="btn btn-primary btn-sm selectAvailableDate" data-user="{{$user->id}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->stop}}">Seleziona una data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @empty
                                <h6 class="text-center text-muted">Nessun inquilino</h6>
                                @endforelse                         
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
    });

    $(".accept-user").on("click", function () {
        var button = $(this);

        var url = '{{route('allow.user', [ 'room' => ':room', 'user' => ':user'])}}';

        $.post(url.replace(':room', button.data("room")).replace(':user', button.data("user")), function( data ) {
            if(data.status === 'OK') {
                location.reload();
            }
        });
    });

    $(".selectAvailableDate").on('click', function () {
    var button = $(this);
    var dateSelect = document.createElement("select");
    dateSelect.classList.add("form-control");
    dateSelect.classList.add("w-100");
    dateSelect.id = "availableFromDate";

    moment.locale('it');

    option = document.createElement('option');
    option.value = -1;
    option.textContent =  "Seleziona una data";
    option.disabled = true;
    option.selected = true;
    dateSelect.appendChild( option );

    var date = moment(button.data("start-date"), 'YYYY-MM-DD').subtract(1, 'days');
    for(var i = 0; i < 90; i++) {
      date.add(1, 'days');
      option = document.createElement('option');
      option.value = date.format("YYYY-MM-DD");
      option.textContent =  date.format("D MMMM");
      dateSelect.appendChild( option );
    }

    swal({
      title: "Inserisci la data in cui la stanza tornerà disponibile",
      buttons: [true, {
        text: "Salva",
        closeModal: false
      }],
      content: dateSelect
    })
    .then((send) => {

      if (!send) throw null;

      var select = $("#availableFromDate");

      if(select.val() === null || select.val() === -1) throw 'MISSING_DATE';
      var url = '{{route('ajax.setAvailableFrom.room', [ 'room' => ':room', 'user' => ':user'])}}';
      $.post(url.replace(':room', button.data("room")).replace(':user', button.data("user")), { available_from: select.val() }, function( data ) {
        if(data.status === 'OK') {
          swal("Operazione riuscita", "", "success").then(() => { location.reload() });
        } else {
          swal("Si è verificato un errore", "Riprova più tardi", "error");
        }
      });
    })
    .catch(err => {
      if (err) {
        if(err === 'MISSING_DATE') {
          swal("Inserisci la data in cui la stanza tornerà disponibile", "", "error");
        } else {
          swal("Si è verificato un errore", "Riprova più tardi", "error");
        }
      } else {
        swal.stopLoading();
        swal.close();
      }
    });
});


$(".remove-user").on('click', function () {
    var button = $(this);
    var dateSelect = document.createElement("select");
    dateSelect.classList.add("form-control");
    dateSelect.classList.add("w-100");
    dateSelect.id = "RemoveDate";

    moment.locale('it');

    option = document.createElement('option');
    option.value = -1;
    option.textContent =  "Seleziona una data";
    option.disabled = true;
    option.selected = true;
    dateSelect.appendChild( option );

    var date = moment(button.data("start-date"), 'YYYY-MM-DD').subtract(1, 'days');
    for(var i = 0; i < 90; i++) {
      date.add(1, 'days');
      option = document.createElement('option');
      option.value = date.format("YYYY-MM-DD");
      option.textContent =  date.format("D MMMM");
      dateSelect.appendChild( option );
    }

    swal({
      title: "Inserisci la data in cui l'utente dovrà abbandonare l'immobile",
      buttons: [true, {
        text: "Salva",
        closeModal: false
      }],
      content: dateSelect
    })
    .then((send) => {

      if (!send) throw null;

      var select = $("#RemoveDate");

      if(select.val() === null || select.val() === -1) throw 'MISSING_DATE';
      var url = '{{route('ajax.remove.room', [ 'room' => ':room', 'user' => ':user'])}}';
      $.post(url.replace(':room', button.data("room")).replace(':user', button.data("user")), { stop: select.val() }, function( data ) {
        if(data.status === 'OK') {
          swal("Operazione riuscita", "", "success").then(() => { location.reload() });;
        } else {
          swal("Si è verificato un errore", "Riprova più tardi", "error");
        }
      });
    })
    .catch(err => {
      if (err) {
        if(err === 'MISSING_DATE') {
          swal("Inserisci la data in cui l'utente dovrà abbandonare l'immobile", "", "error");
        } else {
          swal("Si è verificato un errore", "Riprova più tardi", "error");
        }
      } else {
        swal.stopLoading();
        swal.close();
        location.reload();
      }
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection