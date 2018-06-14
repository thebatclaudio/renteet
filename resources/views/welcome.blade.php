@extends('layouts.home')

@section('title', 'Be friendly')

@section('styles')
<link rel="stylesheet" href="/css/home.css?{{rand()}}">
@endsection

@section('content')
<div id="fullpage">
  <div class="section" id="section0">
    <div class="blur">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-5">
              <h1>Renteet</h1>
              <h2>Find interesting people to live with</h2>
              <form id="searchForm" class="form-inline margin-top-20" action="{{route('search.coordinates')}}" method="GET">
                  <input id="lat" name="lat" type="hidden" required>
                  <input id="lng" name="lng" type="hidden" required>
                  <input id="search-input" name="searchInput" class="form-control" type="text" onFocus="geolocate()" placeholder="Prova &quot;Palermo&quot;" aria-label="Cerca">
                  <i class="search-icon fa fa-search fa-2x" aria-hidden="true"></i>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section" id="section2">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-7">
              <video width="500px" height="auto" autoplay="autoplay" loop="loop">
                <source src="{{url('videos/blending-animation.mp4')}}" type="video/mp4" />
              </video>
            </div>
            <div class="col-md-4 text-center">
              <h3 class="claim">Oltre a <strong>dove</strong> vivere scegli <strong>con chi</strong> vivere</h3>
              <h4 class="sub-claim">Trova persone con cui condividere casa in un modo in cui non l'hai mai fatto</h4>
              <a href="{{url('/come-funziona/')}}" title="Come funziona" class="btn btn-danger btn-how-it-works margin-top-20">Come funziona</a>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="section" id="section3">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-5 text-center">
              <h3 class="claim">Ottieni il massimo dal tuo <strong>immobile</strong></h3>
              <h4 class="sub-claim">Lascia che sia renteet a organizzare la condivisione del tuo immobile.<br>Ottimizza l’occupaziome offrendo ai tuoi ospiti un’esperieza unica</h4>
              <a href="{{url('/scopri-i-vantaggi/')}}" title="Scopri i vantaggi" class="btn btn-warning btn-how-it-works margin-top-20">Scopri i vantaggi</a>
            </div>
            <div class="col-md-7 text-center">
              <img class="img-fluid" src="{{url('images/homepage/get-the-best-from-your-house.png')}}" alt="Ottieni il massimo dal tuo immobile">
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="section" id="section4">
      <div class="content">
        <div class="container">
          <div class="row justify-content-end">
            <div class="col-md-6 text-center">
              <h3 class="claim">Migliora il rapporto tra <strong>coinquilini</strong> e <strong>locatori</strong></h3>
              <h4 class="sub-claim">Il nostro obiettivo è creare un'esperienza coinvolgente e innovativa</h4>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="section fp-auto-height">
    <div id="call-to-action">
      <div class="blur">
        <div class="content text-center">
          <h3 class="claim">Unisciti alla community</h3>
          <a href="/register" class="btn btn-warning btn-register margin-top-20 btn-lg" class="Iscriviti">Inizia adesso</a>
        </div>
      </div>
    </div>
    <hr class="container" />
    <footer>
        <div class="container text-center">
            <h5 class="renteet-footer">Renteet</h5>
            <h6 class="renteet-slogan">Be friendly</h6>
        </div>
    </footer>
  </div>
</div>

<footer>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#fullpage').fullpage({
      verticalCentered: false,
      slidesNavigation: true,
      onLeave: function(index, nextIndex, direction){
        if(nextIndex == 2) {
          $("#home-navbar").removeClass("transparent-navbar");
        }

        if(nextIndex == 1) {
          $("#home-navbar").addClass("transparent-navbar");
        }
			},
    });
  });
</script>
@endsection