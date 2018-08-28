@extends('layouts.app')

@section('title', $house->name)

@section('content')

  @include("modals.login_modal")

      <div id="houseCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @foreach($house->photos as $photo)
            @if ($loop->first)
              <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($photo->file_name)."-1920.jpg")}})"></div>
            @else
              <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($photo->file_name)."-1920.jpg")}})"></div>
            @endif
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#houseCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#houseCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="house-info">
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="house-name-container">
              
              @for($i = 1; $i < 6; $i++)
                  @if($i <= floor($house->rating))
                      <span class="fas fa-star checked" style="color:#ffffff;"></span>
                  @elseif($i-$house->rating < 0.5)
                      <span class="fas fa-star-half-alt" style="color:#ffffff;"></span>
                  @else
                      <span class="far fa-star" style="color:#ffffff;"></span>
                  @endif
              @endfor

                <h1 class="house-name">{{$house->name}}</h1>
              </div>
            </div>
            <div class="col-auto">
              <a href="#owner-box">
                <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}">
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="container users" style="{{($house->beds > 4) ? 'max-width: 90%;' : ''}}">
        <div class="row">
          @foreach($house->rooms as $room)

            {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI --}}
            @foreach($room->acceptedUsers as $user)
              <div class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                  <a class="no-style" href="{{$user->profile_url}}" title="{{$user->first_name}} {{$user->last_name}}">
                  <img class="rounded-circle" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" width="140" height="140">
                  
                  
                  @if($user->pivot->available_from)
                  <h4 class="free-place">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h4>
                      @if(!$house->hasUser(\Auth::user()->id))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}" data-start="{{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('Y-m-d')}}">Prenota il tuo posto</a></p>
                      @endif
                  @else
                  <h4 class="user-name">{{$user->first_name}} {{$user->last_name}}</h4>
                  @endif
                  </a>
              </div>
            @endforeach

            {{-- PER OGNI STANZA STAMPO I POSTI VUOTI MA NON ANCORA DISPONIBILI --}}
            @foreach($room->notAvailableBeds as $user)
              @if($user->pivot->stop < \Carbon\Carbon::now()->format('Y-m-d'))
              <div class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile" width="140" height="140">
                <h4 class="free-place">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h4>
                @if(!$house->hasUser(\Auth::user()->id))
                  <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}" data-start="{{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('Y-m-d')}}">Prenota il tuo posto</a></p>
                @endif
              </div>
              @endif
            @endforeach

            {{-- se ci sono posti liberi --}}
            @if($room->beds - ($room->acceptedUsers->count() + $room->notAvailableBeds->count()))
            
              {{-- controllo se l'utente è loggato --}}
              @if(\Auth::check())
                {{-- controllo se l'utente loggato è pending, in caso positivo stampo l'utente loggato --}}
                @if($room->hasUserPending(\Auth::user()->id))
                  <div class="bed-container col-lg-4 pending" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                    <img class="rounded-circle {{\Auth::user()->gender}}" src="{{\Auth::user()->profile_pic}}" alt="{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}" width="140" height="140">
                    <h4 class="user-name {{\Auth::user()->gender}}">In attesa di approvazione</h4>
                  </div>
                  {{-- quindi stampo gli altri posti liberi, sottraendo il posto pending dell'utente loggato --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count()-1; $i++)   
                    <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                      <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="{{$room->bed_price}}€" width="140" height="140">
                      <h4 class="free-place">{{$room->bed_price}}€</h4>
                      @if(\Auth::check())
                      @if(!in_array(\Auth::user()->id, $house->relatedUsers()))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                      @endif
                      @endif
                    </div>
                  @endfor
                @else
                  {{-- viceversa stampo TUTTI gli altri posti liberi --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                    <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                      <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="{{$room->bed_price}}€" width="140" height="140">
                      <h4 class="free-place">{{$room->bed_price}}€</h4>
                      @if(\Auth::check())
                      @if(!in_array(\Auth::user()->id, $house->relatedUsers()))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                      @endif
                      @endif
                    </div>
                  @endfor
                @endif
              @else
                {{-- se l'utente non è loggato stampo TUTTI gli altri posti liberi --}}
                @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                  <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                    <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="{{$room->bed_price}}€" width="140" height="140">
                    <h4 class="free-place">{{$room->bed_price}}€</h4>
                    @if(\Auth::check())
                    @if(!in_array(\Auth::user()->id, $house->relatedUsers()))
                    <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                    @endif
                    @endif
                  </div>
                @endfor
              @endif
            @endif
          @endforeach
        </div><!-- /.row -->
        
        <div class="rooms-container row">
          @foreach($house->rooms as $room)
          <div class="col-lg-4" style="width: {{(100/$house->beds)*$room->beds}}%; flex: 0 0 {{(100/$house->beds)*$room->beds}}%; max-width: {{(100/$house->beds)*$room->beds}}%;"><div class="room"></div></div>
          @endforeach
        </div><!-- /.row -->
      </div><!-- /.container -->

      <div class="container">

        <div class="row">
            <div class="page-target-container margin-top-80">
              <h3 class="page-target">Descrizione</h3>
            </div>
          <div class="margin-top-120">
            <p class="margin-top-40">{{$house->description}}</p>
          </div>  
        </div>
        
        <div class="row">
            <div class="page-target-container margin-top-80">
              <h3 class="page-target">Informazioni</h3>
            </div>
          <div class="margin-top-120">
            <ul class="margin-top-40 list-unstyled">
              <li>Tipologia: {{$house->type->name}}</li>
              <li>Numero stanze: {{$house->rooms()->count()}}</li>
              <li>Numero bagni: {{$house->bathrooms}}</li>
              <li>MQ: {{$house->mq}}</li>
              <li>Genere coinquilini: {{$house->gender}}</li>
            </ul>
          </div>  
        </div>

        <div class="row">
          <div class="page-target-container margin-top-80">
            <h3 class="page-target">Servizi</h3>
          </div>
            <div class="col-md-6 margin-top-120">
              <ul class="margin-top-40 list-unstyled">
                @foreach($house->services()->quantityNeeded(true)->get() as $service)
                <li>
                  <div class="row">
                    <div class="col-md-6">
                      {{$service->name}}
                    </div>
                    <div class="col-md-6">
                    <h5><span class="badge badge-dark">{{$service->pivot->quantity}}</span></h5>
                    </div>
                  </div>
                </li>
                @endforeach

                @if($house->other_services)
                  <h5 class="margin-top-20">Altri servizi:</h5>
                  <p>{{$house->other_services}}</p>
                @endif
              </ul>
            </div>
            <div class="col-md-6 margin-top-120">
              <ul class="margin-top-40 list-unstyled">
              @foreach($house->services()->quantityNeeded(false)->get() as $service)
                <li>{{$service->name}}</li>
              @endforeach
              </ul>
            </div>
        </div>

        <div class="row">
          <div class="page-target-container margin-top-80">
            <h3 class="page-target">Posizione approssimata</h3>
          </div>
          <div class="col-md-6 margin-top-120">
            <div class="margin-top-40" id="map"></div>
          </div>
        </div>

        @if($house->previewReviews->count())
        <div class="row">
          <div class="page-target-container margin-top-80">
            <h3 class="page-target">Recensioni</h3>
          </div>
          <div id="reviewsCarousel" class="carousel slide col-md-12" data-ride="carousel">
            <div class="carousel-inner margin-top-180">
              @foreach($house->previewReviews as $review)
                @if ($loop->index % 3 === 0)
                  @if($loop->first)
                    <div class="carousel-item active">
                    <div class="row">
                  @else
                    <div class="carousel-item">
                    <div class="row">
                  @endif
                @endif
                <div class="col-md-4 text-center">
                <a href="{{$review->fromUser->profile_url}}" title="{{$review->fromUser->complete_name}}">
                  <img src="{{$review->fromUser->profile_pic}}" alt="{{$review->fromUser->first_name}} {{$review->fromUser->last_name}}" class="rounded-circle" style="max-width:120px;">
                </a>
                <h6 class="margin-top-15">{{$review->fromUser->first_name}}</h6>
                <div class="rating-stars-container margin-top-20">
                  @for($i = 1; $i < 6; $i++)
                    @if($i <= $review->rate)
                        <span class="fas fa-star checked"></span>
                    @else
                        <span class="far fa-star"></span>
                    @endif
                  @endfor
                </div>
                <p class="margin-top-10">{{$review->text}}</p>
                </div>
                @if($loop->index % 3 === 2)
                  </div>
                  </div>
                @elseif($loop->last)
                  </div>
                  </div>
                @endif
              @endforeach
            </div>
              <a class="carousel-control-prev" href="#reviewsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#reviewsCarousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
              </a>
          </div>
        </div>
        @endif

        <div class="row margin-bottom-40" id="owner-box">
          <div class="page-target-container margin-top-80">
            <h3 class="page-target">Proprietario</h3>
          </div>
          <div class="card margin-top-180 col-md-8">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3 text-center">
                  <a href="{{$house->owner->profile_url}}">
                    <img src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->last_name}}" class="rounded-circle img-fluid">
                  </a>
                  @if(\Auth::check())
                    @if(\Auth::user()->id != $house->owner->id)
                      <buttom id="new-message-button" class="btn btn-elegant btn-sm  margin-top-20">Invia messaggio</buttom>
                    @endif
                  @endif
                </div>
                <div class="col-sm-9 padding-left-20">
                  <h3 class="mb-1 margin-top-10">{{$house->owner->first_name}} {{$house->owner->last_name}}</h3>
                  <ul class="list-unstyled">
                    <li>{{\Carbon\Carbon::parse($house->owner->birthday)->age}} Anni, {{$house->owner->job}}</li>
                    <li>{{$house->owner->livingCity()->getResults()->text}}</li>
                  </ul>
                  <p>Email: <a href="mailto:{{$house->owner->email}}">{{$house->owner->email}}</a></p>
                </div>
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

      $(document).ready(function(){
        
        var latitudeApprox = {{$house->latitude}};
        var longitudeApprox = {{$house->longitude}};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: {lat: latitudeApprox, lng: longitudeApprox},
          mapTypeId: 'terrain'
        });

        var cityCircle = new google.maps.Circle({
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35,
          map: map,
          center: {lat: latitudeApprox, lng: longitudeApprox},
          radius: 100
        });
      });

      @if(\Auth::check() && !$house->hasUser(\Auth::user()->id))
      $(".free-bed").on("click", function () {

        var button = $(this).children("p").children(".rent-house");

        var dateSelect = document.createElement("select");
        dateSelect.classList.add("form-control");
        dateSelect.id = "start-date";

        moment.locale('it');

        option = document.createElement('option');
        option.value = -1;
        option.textContent =  "Seleziona una data";
        option.disabled = true;
        option.selected = true;
        dateSelect.appendChild( option );

        // se è una prenotazione ("Disponibile dal...") allora faccio partire la select dalla data di ritorno alla disponibilità

        if(button.data('start')){
          var date = moment(button.data("start"), 'YYYY-MM-DD').subtract(1, 'days');
        } else {
          var date = moment().subtract(1, 'days');
        }
        for(var i = 0; i < 90; i++) {
          date.add(1, 'days');
          option = document.createElement('option');
          option.value = date.format("YYYY-MM-DD");
          option.textContent =  date.format("D MMMM");
          dateSelect.appendChild( option );
        }

        swal({
          title: "Inserisci la data in cui inizierai il tuo soggiorno",
          text: "Il proprietario potrà approvare o rifiutare la tua richiesta di adesione all'immobile",
          buttons: [true, {
            text: 'Prendi posto',
            closeModal: false
          }],
          content: dateSelect
        })
        .then((send) => {

          if (!send) throw null;

          var select = $("#start-date");

          if(select.val() === null || select.val() === -1) throw 'MISSING_DATE';

          var url = '{{route('ajax.rent.room', ':id')}}';
          $.post(url.replace(':id', button.data("id")), { startDate: select.val() }, function( data ) {
            if(data.status === 'OK') {
              $("#bed-"+button.data("id")+"-"+button.data("bed")).removeClass("free-bed").addClass("{{\Auth::user()->gender}}");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" img").attr("src", "{{URL::to("/images/profile_pics/".\Auth::user()->id."-cropped.jpg")}}");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" h4").removeClass("free-place").addClass("user-name").text("{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" p").remove();

              swal("Buona convivenza!", "Contatta il locatore per organizzare il primo incontro", "success");
            } else if(data.status === 'WAITING') {
              $("#bed-"+button.data("id")+"-"+button.data("bed")).removeClass("free-bed").addClass("pending");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" img").attr("src", "{{URL::to("/images/profile_pics/".\Auth::user()->id."-cropped.jpg")}}");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" h4").removeClass("free-place").addClass("user-name").text("In attesa di approvazione");
              $("#bed-"+button.data("id")+"-"+button.data("bed")+" p").remove();

              swal("Richiesta di adesione inviata!", "Attendi una risposta dal locatore", "success");
            } else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
          });
        })
        .catch(err => {
          if (err) {
            if(err === 'MISSING_DATE') {
              swal("Inserisci la data in cui inizierai il tuo soggiorno", "", "error");
            } else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
          } else {
            swal.stopLoading();
            swal.close();
          }
        });
      });
      @elseif(!\Auth::check())

      $(".free-bed").on("click", function () {
        $("#login-modal").modal("show");
      });
      @endif;

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
          title: "Invia un messaggio a {{$house->owner->first_name}}",
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
          $.post(url.replace(':id','{{$house->owner->id}}'), {message:$('#textareaMessage').val()}, function( data ) {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection

@section('styles')
<style>
#map {
  height: 400px;
}
#reviewsCarousel .carousel-inner{
  width:90%;
  margin:180px auto 0px;
}

#reviewsCarousel .carousel-control-prev, #reviewsCarousel .carousel-control-next{
  width:5%;
}

#reviewsCarousel .carousel-control-prev-icon, #reviewsCarousel .carousel-control-next-icon{
  background-color:#212121;
}

#reviewsCarousel .carousel-item{
  height:auto;
}
</style>
@endsection