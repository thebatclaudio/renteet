@extends('layouts.app')

@section('title', 'Be friendly')

@section('styles')
<style>
.users {
    margin-top: -75px;
}
</style>
@endsection

@section('content')
<div class="container margin-top-20">
    
    <div class="row">
        <div class="col-auto">
            @if($searchInput)
                <h3>Immobili attualmente disponibili nei dintorni di <strong>{{$searchInput}}</strong></h3>
            @else
                <h3>Immobili attualmente disponibili nei tuoi dintorni</h3>
            @endif
        </div>
        <div class="col text-right">
            <div class="btn-group" role="group" aria-label="Cambia la modalità di visualizzazione degli annunci">
                <a id="grid-view"  class="btn btn-change-view btn-outline-elegant" title="Visualizzazione a griglia" data-view="grid"><i class="fas fa-th"></i></a>
                <a class="btn btn-change-view btn-elegant" title="Visualizzazione a elenco" data-view="list"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>
    
    <hr>

    <div class="search-results margin-top-40">
        @forelse($houses as $house)
        <div class="row margin-top-80">
            <div class="house-col col-sm-8">
                <div id="house-{{$house->id}}" class="house">
                    
                    <div class="owner-container {{$house->owner->gender}}">
                      <a class="no-style" href="{{$house->owner->profile_url}}" title="{{$house->owner->first_name}} {{$house->owner->last_name}}">
                        <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
                        <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
                      </a>
                    </div>

                    <div class="photos-container">
                        <div class="row">
                            @if(isset($house->photos[1]))
                            <div class="col-md-7">
                                @if(isset($house->photos[0]))
                                <div class="house-img house-img-big" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name)."-670.jpg")}})"></div>
                                @endif
                            @else
                            <div class="col-md-12">
                                @if(isset($house->photos[0]))
                                <div class="house-img house-img-big" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name)."-1920.jpg")}})"></div>
                                @endif
                            @endif
                            </div>
                            <div class="col-md-5">
                                @if(isset($house->photos[1]) && isset($house->photos[2]))
                                <div class="house-img house-img-big half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name)."-490.jpg")}})"></div>
                                <div class="house-img house-img-big half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[2]->file_name)."-490.jpg")}})"></div>
                                @elseif(isset($house->photos[1]))
                                <div class="house-img house-img-big" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name)."-490.jpg")}})"></div>
                                @endif
                            </div>
                        </div>
                    </div>

      <div class="container users">
        <div class="row">

          @php
            $bedsCount = 0;
            $circleWidth = ($house->beds > 4) ? 25 : (100/$house->beds);
          @endphp

          @foreach($house->rooms as $room)
            
            {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI --}}
            @foreach($room->acceptedUsers as $user)
              @if($bedsCount<3 OR $house->beds == 4)
              <div class="bed-container col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                <a class="no-style" href="{{$user->profile_url}}" title="{{$user->first_name}} {{$user->last_name}}">
                  <img class="rounded-circle {{$user->gender}}" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" width="140" height="140">
                  <h4 class="user-name {{$user->gender}}">{{$user->first_name}} {{$user->last_name}}</h4>
                </a>
              </div>
              @endif

              @php
                $bedsCount++;
              @endphp
              
            @endforeach

            {{-- PER OGNI STANZA STAMPO I POSTI VUOTI MA NON ANCORA DISPONIBILI --}}
            @foreach($room->notAvailableBeds as $user)
              @if($bedsCount<3 OR $house->beds == 4)
                <div class="bed-container col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                  <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile" width="140" height="140">
                  <h4 class="free-place">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h4>
                </div>
              @endif

              @php
                $bedsCount++;
              @endphp
            @endforeach

            {{-- se ci sono posti liberi --}}
            @if($room->beds - ($room->acceptedUsers->count() + $room->notAvailableBeds->count()))
      
              {{-- controllo se l'utente è loggato --}}
              @if(\Auth::check())
                {{-- controllo se l'utente loggato è pending, in caso positivo stampo l'utente loggato --}}
                @if($room->hasUserPending(\Auth::user()->id))
                  @if($bedsCount<3 OR $house->beds == 4)
                  <div class="bed-container col-lg-4 pending" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                    <img class="rounded-circle {{\Auth::user()->gender}}" src="{{\Auth::user()->profile_pic}}" alt="{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}" width="140" height="140">
                    <h4 class="user-name {{\Auth::user()->gender}}">In attesa di approvazione</h4>
                  </div>
                  @endif

                  @php
                    $bedsCount++;
                  @endphp
                  {{-- quindi stampo gli altri posti liberi, sottraendo il posto pending dell'utente loggato --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count()-1; $i++)
                    @if($bedsCount<3 OR $house->beds == 4)
                      <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                        <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="Posto libero" width="140" height="140">
                        <h4 class="free-place">{{$room->bed_price}}€</h4>
                        @if(!$house->hasUser(\Auth::user()->id))
                        <p><a class="btn btn-primary rent-house" href="{{$house->url}}" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Visualizza</a></p>
                        @endif
                      </div>
                    @endif

                    @php
                      $bedsCount++;
                    @endphp
                  @endfor
                @else
                  {{-- viceversa stampo TUTTI gli altri posti liberi --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                    @if($bedsCount<3 OR $house->beds == 4)
                      <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                        <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="Posto libero" width="140" height="140">
                        <h4 class="free-place">{{$room->bed_price}}€</h4>
                        @if(!$house->hasUser(\Auth::user()->id))
                        <p><a class="btn btn-primary rent-house" href="{{$house->url}}" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Visualizza</a></p>
                        @endif
                      </div>
                    @endif

                    @php
                      $bedsCount++;
                    @endphp
                  @endfor
                @endif
              @else
                {{-- se l'utente non è loggato stampo TUTTI gli altri posti liberi --}}
                @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)
                    @if($bedsCount<3 OR $house->beds == 4)
                      <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">
                        <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="Posto libero" width="140" height="140">
                        <h4 class="free-place">{{$room->bed_price}}€</h4>
                        <p><a class="btn btn-primary rent-house" href="{{$house->url}}" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Visualizza</a></p>
                      </div>
                    @endif

                    @php
                      $bedsCount++;
                    @endphp
                @endfor
              @endif
            @endif
          @endforeach

          @if($house->beds > 4)
              <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{$circleWidth}}%; flex: 0 0 {{$circleWidth}}%; max-width: {{$circleWidth}}%;">         
                <a href="{{$house->url}}" title="Visualizza l'appartamento" target="_blank">
                  <div class="circle more-users border-shadow">
                      + {{$house->beds - 3}}
                  </div>
                </a>
              </div>
            </a>
          @endif
        </div><!-- /.row -->
        
        <div class="rooms-container row">
          @php
            $bedsCount = 0;
          @endphp

          @foreach($house->rooms as $room)
            @if($bedsCount + $room->beds < 4)
              <div class="col-lg-4" style="width: {{($circleWidth)*$room->beds}}%; flex: 0 0 {{($circleWidth)*$room->beds}}%; max-width: {{($circleWidth)*$room->beds}}%;"><div class="room"></div></div>
            @elseif($bedsCount < 4)
              <div class="col-lg-4" style="width: {{($circleWidth)*(4-$bedsCount)}}%; flex: 0 0 {{($circleWidth)*(4-$bedsCount)}}%; max-width: {{($circleWidth)*(4-$bedsCount)}}%;"><div class="room"></div></div>
            @endif

            @php
              $bedsCount+=$room->beds;
            @endphp
          @endforeach
        </div><!-- /.row -->
      </div><!-- /.container -->

                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                  <div class="card-body">
                        <!-- Title -->
                        <h4 class="card-title">{{$house->name}}</h4>

                        <ul class="list-unstyled">
                            <li>Tipologia: {{$house->type->name}}</li>
                            <li>Numero stanze: {{$house->rooms()->count()}}</li>
                            <li>Numero bagni: {{$house->bathrooms}}</li>
                            <li>MQ: {{$house->mq}}</li>
                            <li>Genere coinquilini: {{$house->gender}}</li>
                        </ul>

                        <!-- Text -->
                        <p class="card-text">{{$house->description}}</p>
                    </div>
                </div>

                <div class="house-price margin-top-40 text-right">
                    <a href="{{$house->url}}" class="btn btn-dark margin-left-5">Visualizza L'appartamento</a>
                </div>
            </div>
        </div>
        @empty
            <div class="col">
                <h4 class="text-muted text-center">Nessun immobile trovato</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
$("#grid-view").click(function(){
    window.location = window.location + "&view=grid";
});
</script>
@endsection