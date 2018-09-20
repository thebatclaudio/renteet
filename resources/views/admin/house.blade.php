@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container margin-top-20">
    <!-- Split button -->
    <div class="btn-group float-sm-right">
        <a class="btn btn-outline-elegant" href="{{route('admin.house.edit.info', $house->id)}}">Modifica informazioni</a>
        <button type="button" class="btn btn-outline-elegant dropdown-toggle px-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-caret-down"></i>
            <span class="sr-only">Apri Dropdown</span>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('admin.house.edit.services', $house->id)}}">Modifica i servizi</a>
            <a class="dropdown-item" href="{{route('admin.house.edit.photos', $house->id)}}">Modifica le foto</a>
            <a class="dropdown-item" href="{{route('admin.house.edit.rooms', $house->id)}}">Modifica stanze e prezzi</a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Gestisci immobile</div>

        <div class="panel-body">
                    <h2>{{$house->name}}</h2>
            <hr>

            <div class="container margin-top-40" style="{{($house->beds > 4) ? 'max-width: 90%;' : ''}}">
                <div class="row beds-row">
                @foreach($house->rooms as $room)

                    {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI --}}
                    @foreach($room->acceptedUsers as $user)
                        <div class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                            <a href="{{$user->profile_url}}"><img class="rounded-circle" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" data-toggle="tooltip" data-placement="bottom" title="Visualizza profilo"></a>
                            
                            @if($user->pivot->available_from)
                                <h6 class="free-place margin-top-10">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h6>
                            @else
                                <h6 class="user-name margin-top-10">{{$user->first_name}} {{$user->last_name}}</h6>
                            @endif

                            @if($user->pivot->start > \Carbon\Carbon::now()->format('Y-m-d'))
                                <small class="mb-1 margin-top-10">Acceder&agrave; all'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->start)->format('d/m/Y')}}</small>
                            @endif

                            @if($user->pivot->stop === null)
                                <button class="btn btn-elegant btn-sm remove-user" data-user="{{$user->id}}" data-name="{{$user->complete_name}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->start}}">Rimuovi</button>
                            @elseif($user->pivot->stop !== null && $user->pivot->available_from === null)
                                @if(\Carbon\Carbon::now()->format('Y-m-d') < $user->pivot->stop)
                                    <small class="mb-1 margin-top-10">Abbandoner&agrave; l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</small>
                                @else
                                    <small class="mb-1 margin-top-10">Ha abbandonato l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</small>
                                @endif
                                <button class="btn btn-success btn-sm selectAvailableDate" data-user="{{$user->id}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->stop}}">Imposta disponibilità</button>
                            @endif
                        </div>
                    @endforeach

                    {{-- PER OGNI STANZA STAMPO I POSTI VUOTI MA NON ANCORA DISPONIBILI --}}
                    @foreach($room->notAvailableBeds as $user)
                        @if($user->pivot->stop < \Carbon\Carbon::now()->format('Y-m-d'))
                            <div class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                                <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile">
                                <h6 class="free-place margin-top-10">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h6>
                            </div>
                        @endif
                    @endforeach

                    {{-- se ci sono posti liberi --}}
                    @if($room->beds - ($room->acceptedUsers->count() + $room->notAvailableBeds->count()))
                        @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                            <div id="bed-{{$room->id}}-{{$i}}" class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                            <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="{{$room->bed_price}}€">
                            <h6 class="free-place margin-top-10">{{$room->bed_price}}€</h6>
                            </div>
                        @endfor
                    @endif
                @endforeach
                </div><!-- /.row -->
                
                <div class="rooms-container row margin-top-10">
                @foreach($house->rooms as $room)
                <div class="col-lg-4" style="width: {{(100/$house->beds)*$room->beds}}%; flex: 0 0 {{(100/$house->beds)*$room->beds}}%; max-width: {{(100/$house->beds)*$room->beds}}%;">
                    <div class="room"></div>
                    <h6 class="text-uppercase text-center margin-top-10">Stanza {{$loop->index +1}}</h6>
                </div>
                @endforeach
                </div><!-- /.row -->
            </div><!-- /.container -->


            <div class="row margin-top-80">
                <div class="col-sm-6">
                    <h5>Richieste di adesione</h5>
                    <hr>
                    @foreach($house->rooms as $room)
                        @php
                            $roomName = "Stanza ".($loop->index+1);
                        @endphp
                        @foreach($room->pendingUsers as $user)
                            <div class="card margin-top-20">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <a href="{{$user->profile_url}}"><img src="{{$user->profile_pic}}" class="rounded-circle img-fluid" data-toggle="tooltip" data-placement="bottom" title="Visualizza profilo"></a>
                                        </div>
                                        <div class="col-sm-9 padding-left-20">
                                            <small class="text-uppercase"><strong>{{$roomName}}</strong></small>
                                            <h5><strong>{{$user->first_name}} {{$user->last_name}}</strong></h5>
                                            <ul class="list-unstyled">
                                                <li>Inizio soggiorno: <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->start)->format('d/m/Y')}}</strong></li>
                                                <li><small>Richiesta inviata il {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user->pivot->created_at)->format('d/m/Y')}}</small></li>
                                            
                                            </ul>
                                            
                                            <button class="btn btn-success btn-sm accept-user" data-user="{{$user->id}}" data-room="{{$room->id}}" data-name="{{$user->complete_name}}">Accetta</button>
                                            {{--<button class="btn btn-elegant btn-sm refuse-user" data-user="{{$user->id}}" data-room="{{$room->id}}">Rifiuta</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <div class="col-sm-6">
                    <h5>Ospiti precedenti</h5>
                    <hr>
                    @foreach($house->rooms as $room)
                        @php
                            $roomName = "Stanza ".($loop->index+1);
                        @endphp
                        @foreach($room->previousUsers()->limit(5)->get() as $user)
                            <div class="card margin-top-20">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <a href="{{$user->profile_url}}"><img src="{{$user->profile_pic}}" class="rounded-circle img-fluid" width="80" data-toggle="tooltip" data-placement="bottom" title="Visualizza profilo"></a>
                                        </div>
                                        <div class="col">
                                            <h5><strong>{{$user->first_name}} {{$user->last_name}}</strong></h5>
                                            <ul class="list-unstyled">
                                                <li>Ha soggiornato dal <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->start)->format('d/m/Y')}}</strong> al <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</strong></li>
                                            </ul>

                                            @if(\App\Review::where('room_user_id', $user->pivot->id)->where('from_user_id', \Auth::user()->id)->where('to_user_id', $user->id)->count())
                                                <div class="alert alert-light" role="alert"><i class="fas fa-check"></i> Ospite recensito</div>
                                            @else
                                                <button class="btn btn-outline-success btn-sm review-user" data-name="{{$user->complete_name}}" data-user="{{$user->id}}" data-room-user="{{$user->pivot->id}}">Lascia una recensione</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        @endforeach
                    @endforeach
                </div>
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    /** ACCEPT USER **/
    $(".accept-user").on("click", function () {
        var button = $(this);

        var url = '{{route('allow.user', [ 'room' => ':room', 'user' => ':user'])}}';

        swal({
            title: "Sei sicuro di voler approvare la richiesta di adesione di "+button.data("name")+"?",
            icon: "warning",
            buttons: [true, {
                text: "Accetta"
            }]
        }).then((send) => {
            if (!send) throw null;

            $.post(url.replace(':room', button.data("room")).replace(':user', button.data("user")), function( data ) {
                if(data.status === 'OK') {
                    swal("Operazione riuscita", "", "success").then(() => { location.reload() });
                } else {
                    swal("Si è verificato un errore", "Riprova più tardi", "error");
                }
            });
        });
    });

    /** REMOVE USER **/
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

        if(moment(button.data("start-date"), 'YYYY-MM-DD').diff(moment(), 'days') < 0) {
            var date = moment().subtract(1, 'days');
        } else {
            var date = moment(button.data("start-date"), 'YYYY-MM-DD').subtract(1, 'days');
        }

        for(var i = 0; i < 90; i++) {
            date.add(1, 'days');
            option = document.createElement('option');
            option.value = date.format("YYYY-MM-DD");
            option.textContent =  date.format("D MMMM");
            dateSelect.appendChild( option );
        }

        swal({
            title: "Inserisci la data in cui "+button.data("name")+" dovrà abbandonare l'immobile",
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
                    swal("Operazione riuscita", "", "success").then(() => { location.reload() });
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

    /** SELECT AVAILABILITY **/
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

        if(moment(button.data("start-date"), 'YYYY-MM-DD').diff(moment(), 'days') < 0) {
            var date = moment().subtract(1, 'days');
        } else {
            var date = moment(button.data("start-date"), 'YYYY-MM-DD').subtract(1, 'days');
        }

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

    $(".review-user").click(function(){

        var button = $(this);

        swal({
            title: "Recensisci "+button.data('name'),
            buttons: [true, {
                text: "Avanti",
                className: "nextButtonSwal",
                closeModal: false
            }],
            content: ratingSystem()
        }).then((send) =>{
            if(!send) throw null;
            if(!$('#hiddenInputStar').val() || !$('#textareaReview').val() || $('#textareaReview').val() == "") throw 'MISSING_DATA';

            var url = '{{route('user.rate', ':id')}}';
            $.post(url.replace(':id',button.data('user')), { 
                rating: $('#hiddenInputStar').val(),
                message:$('#textareaReview').val(),
                room_user_id: button.data('room-user'),
                tenant: true
            }, function( data ) {
                if(data.status === 'OK') {
                    swal("Recensione inserita correttamente", "", "success").then(() => {
                        location.reload();  
                    });
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
    });

    function ratingSystem(){
        var starsContainer = document.createElement("form");
        starsContainer.classList.add('rating-stars-container');

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
        textArea.classList.add('w-100');
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