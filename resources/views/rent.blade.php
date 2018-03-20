@extends('layouts.app')

@section('title', 'Rent '.$house->owner->first_name.'\'s house')

@section('content')

  @include("modals.login_modal")

      <div id="houseCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          @foreach($house->photos as $photo)
            @if ($loop->first)
              <div class="carousel-item active" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
            @else
              <div class="carousel-item" style="background-image: url({{URL::to("/images/houses/".$house->id."/".$photo->file_name)}})"></div>
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
          <div class="house-name-container">
            <h1 class="house-name">{{$house->name}}</h1>
            <p class="house-location"><i class="fa fa-map-marker"></i> {{$house->street_name}}, {{$house->number}} - {{$house->city}}</p>
          </div>

          <div class="owner-container {{$house->owner->gender}}">
            <div class="host-title">Host</div>
            <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
            <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
          </div>
        </div>
      </div>

      <div class="container users">
        <div class="row">
          @foreach($house->rooms as $room)

            {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI --}}
            @foreach($room->acceptedUsers as $user)
            <div class="bed-container col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
              <img class="rounded-circle {{$user->gender}}" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" width="140" height="140">
              <h4 class="user-name {{$user->gender}}">{{$user->first_name}} {{$user->last_name}}</h4>
            </div>
            @endforeach

            {{-- se ci sono posti liberi --}}
            @if($room->beds - $room->acceptedUsers->count())
            
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
                      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                      <h4 class="free-place">Posto libero</h4>
                      @if(!$house->hasUser(\Auth::user()->id))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                      @endif
                    </div>
                  @endfor
                @else
                  {{-- viceversa stampo TUTTI gli altri posti liberi --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                    <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                      <h4 class="free-place">Posto libero</h4>
                      @if(!$house->hasUser(\Auth::user()->id))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                      @endif
                    </div>
                  @endfor
                @endif
              @else
                {{-- se l'utente non è loggato stampo TUTTI gli altri posti liberi --}}
                @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                  <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                    <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
                    <h4 class="free-place">Posto libero</h4>
                    <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
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

        <div class="beds-container row">
          @foreach($house->rooms as $room)
          <div class="col-lg-4 text-center beds-number" style="width: {{(100/$house->beds)*$room->beds}}%; flex: 0 0 {{(100/$house->beds)*$room->beds}}%; max-width: {{(100/$house->beds)*$room->beds}}%;">
            <i class="fa fa-bed"></i>
            @if($room->beds > 1)
             x {{$room->beds}}
            @endif
          </div>
          @endforeach
        </div><!-- /.row -->

      </div><!-- /.container -->
@endsection

@section('scripts')
    <script type="text/javascript">
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
      });

      @if(\Auth::check() && !$house->hasUser(\Auth::user()->id))
      $(".free-bed").on("click", function () {
        var button = $(this).children("p").children(".rent-house");

        var url = '{{route('rent.room', ':id')}}';

        $.post(url.replace(':id', button.data("id")), function( data ) {
          if(data.status === 'OK') {
            $("#bed-"+button.data("id")+"-"+button.data("bed")).removeClass("free-bed").addClass("pending");
            $("#bed-"+button.data("id")+"-"+button.data("bed")+" img").attr("src", "{{URL::to("/images/profile_pics/".\Auth::user()->id.".jpg")}}");
            //$("#bed-"+button.data("id")+"-"+button.data("bed")+" h4").removeClass("free-place").addClass("user-name").text("{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}");
            $("#bed-"+button.data("id")+"-"+button.data("bed")+" h4").removeClass("free-place").addClass("user-name").text("In attesa di approvazione");
            $("#bed-"+button.data("id")+"-"+button.data("bed")+" p").remove();
          }
        });
      });
      @else

      $(".free-bed").on("click", function () {
        $("#login-modal").modal("show");
      });
      @endif;
    </script>
@endsection