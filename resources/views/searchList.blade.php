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
            <h3>Immobili attualmente disponibili nei dintorni di <strong>{{$searchInput}}</strong></h3>
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
                        <div class="owner-name">{{$house->owner->first_name}} {{$house->owner->last_name}}</div>
                        <img class="owner-pic rounded-circle" src="{{$house->owner->profile_pic}}" alt="{{$house->owner->first_name}} {{$house->owner->first_name}}" width="80" height="80">
                    </div>

                    <div class="photos-container">
                        <div class="row">
                            @if(isset($house->photos[1]))
                            <div class="col-md-7">
                            @else
                            <div class="col-md-12">
                            @endif
                                @if(isset($house->photos[0]))
                                <div class="house-img house-img-big" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[0]->file_name))}})"></div>
                                @endif
                            </div>
                            <div class="col-md-5">
                                @if(isset($house->photos[1]) && isset($house->photos[2]))
                                <div class="house-img house-img-big half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name))}})"></div>
                                <div class="house-img house-img-big half" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[2]->file_name))}})"></div>
                                @elseif(isset($house->photos[1]))
                                <div class="house-img house-img-big" style="background-image: url({{URL::to("/images/houses/".$house->id."/".rawurlencode($house->photos[1]->file_name))}})"></div>
                                @endif
                            </div>
                        </div>
                    </div>

      <div class="container users">
        <div class="row">
          @foreach($house->rooms as $room)

            {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI --}}
            @foreach($room->acceptedUsers as $user)
              <div class="bed-container col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                <a class="no-style" href="{{$user->profile_url}}" title="{{$user->first_name}} {{$user->last_name}}">
                  <img class="rounded-circle {{$user->gender}}" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" width="140" height="140">
                  <h4 class="user-name {{$user->gender}}">{{$user->first_name}} {{$user->last_name}}</h4>
                </a>
              </div>
            @endforeach

            {{-- PER OGNI STANZA STAMPO I POSTI VUOTI MA NON ANCORA DISPONIBILI --}}
            @foreach($room->notAvailableBeds as $user)
              <div class="bed-container col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile" width="140" height="140">
                <h4 class="free-place">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h4>
              </div>
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
                      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Posto libero" width="140" height="140">
                      <h4 class="free-place">{{$room->bed_price}}€</h4>
                      @if(!$house->hasUser(\Auth::user()->id))
                      <p><a class="btn btn-primary rent-house" href="#" role="button" data-id="{{$room->id}}" data-bed="{{$i}}">Prendi posto</a></p>
                      @endif
                    </div>
                  @endfor
                @else
                  {{-- viceversa stampo TUTTI gli altri posti liberi --}}
                  @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                    <div id="bed-{{$room->id}}-{{$i}}" class="bed-container free-bed col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                      <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Posto libero" width="140" height="140">
                      <h4 class="free-place">{{$room->bed_price}}€</h4>
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
                    <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Posto libero" width="140" height="140">
                    <h4 class="free-place">{{$room->bed_price}}€</h4>
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
          </div>
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
                    A partire da <strong class="price">{{$house->minorBedPrice()}}€</strong>
                    <a href="{{$house->url}}" class="btn btn-dark btn-sm margin-left-5">Visualizza L'appartamento</a>
                </div>
            </div>
        </div>
        @empty
            <h4 class="text-muted text-center">Nessuna casa trovata</h4>
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