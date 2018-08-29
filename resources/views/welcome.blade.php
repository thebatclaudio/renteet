@extends('layouts.home')

@section('title', 'Oltre a dove vivere scegli con chi vivere')

@section('styles')
<link rel="stylesheet" href="/css/home.css?{{rand()}}">
<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
div#mce-success-response {
    color: #FFF;
    margin-top: 15px;
}

div#mce-error-response {
    color: #fc7f7a;
    margin-top: 15px;
}

footer.page-footer {
  position: relative;
  margin-top: 0px;
  padding: 40px 0px 0px 0px;
}


</style>
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

    <div class="arrow-pulse-down">
      <i id="scroll-down" class="fas fa-angle-down"></i>
    </div>
  </div>
  <div class="section" id="section2">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <video width="100%" height="auto" muted loop autoplay data-autoplay>
                <source src="{{url('videos/blending-animation.mp4')}}" type="video/mp4" />
              </video>
            </div>
            <div class="col-md-6 text-left">
              <div class="content">
                <h3 class="claim">Oltre a <strong>dove</strong> vivere scegli <strong class="green-strong">con chi</strong> vivere</h3>
                <h4 class="sub-claim">Trova persone con cui condividere casa in un modo in cui non l'hai mai fatto</h4>
                <a href="{{url('/come-funziona/')}}" title="Come funziona" class="btn btn-danger btn-how-it-works margin-top-20">Come funziona</a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="section" id="section3">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-6 text-left">
              <div class="content">
                <img class="img-fluid d-block d-sm-none mobile-image margin-top-80" src="{{url('images/homepage/get-the-best-from-your-house.png')}}" alt="Ottieni il massimo dal tuo immobile">
                <h3 class="claim">Ottieni il massimo dal tuo <strong>immobile</strong></h3>
                <h4 class="sub-claim">Accetta personalmente ogni tuo ospite e ottimizza l’occupazione offrendo loro un’esperieza unica</h4>
                <a href="{{url('/scopri-i-vantaggi/locatori')}}" title="Scopri i vantaggi per i locatori" class="btn btn-primary btn-how-it-works margin-top-20">Vantaggi per i locatori</a>
              </div>
            </div>
            <div class="col-md-6 text-left">
              <div class="content">
                <img class="img-fluid d-none d-sm-block" style="max-height: 100%" src="{{url('images/homepage/get-the-best-from-your-house.png')}}" alt="Ottieni il massimo dal tuo immobile">
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="section" id="section4">
      <div class="section4-background">
        <div class="blur">
          <div class="content">
            <div class="container">
              <div class="row justify-content-end">
                <div class="col-lg-6 text-left">
                  <h3 class="claim">Migliorare il rapporto tra <strong>inquilini</strong> e <strong>locatori</strong></h3>
                  <h4 class="sub-claim">Il nostro obiettivo è creare un'esperienza coinvolgente e innovativa</h4>
                  <a href="{{url('/scopri-i-vantaggi/')}}" title="Scopri i vantaggi" class="btn btn-danger btn-how-it-works margin-top-20">Vantaggi per gli ospiti</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="section fp-auto-height">
    <div id="call-to-action">
      <div class="blur">
        <div class="content text-center">
          <div class="container">
            <h3 class="claim">Fai parte di <strong>renteet</strong></h3>
            <h4 class="claim text-white margin-top-20">Iscriviti alla newsletter,<br> non perderti il lancio!</h4>
            <div class="row justify-content-md-center">
              <div class="col-sm-4">
                <div id="mc_embed_signup">
                  <form action="https://renteet.us18.list-manage.com/subscribe/post?u=b095bad4ebe8facfe3dc6d62c&amp;id=6dbf114f3e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                      <div id="mc_embed_signup_scroll">
                    
                      <div class="mc-field-group">
                        <input type="email" placeholder="Indirizzo E-Mail" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                      </div>
                      
                      <div class="row">
                        <div class="col text-white">
                          <input type="radio" value="Sono un locatore" name="MMERGE1" id="mce-MMERGE1-0">
                          <label for="mce-MMERGE1-0">Sono un locatore</label>
                          <input type="radio" value="Sono un ospite" name="MMERGE1" id="mce-MMERGE1-1" class="margin-left-10">
                          <label for="mce-MMERGE1-1">Sono un ospite</label>
                        </div>
                      </div>

                      <div class="clear text-center">
                      <button type="submit" name="subscribe" class="btn btn-lg btn-danger btn-register margin-top-20 text-uppercase">
                        Iscriviti
                      </button>                    
                      </div>


                      <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                      </div>

                      <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="b_b095bad4ebe8facfe3dc6d62c_6dbf114f3e" tabindex="-1" value="">
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('partials.footer')
</div>

@endsection

@section('scripts')
<!--Start mc_embed_signup-->
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
<script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='MMERGE1';ftypes[1]='radio';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
<script>

var topPosition = 200;


// Plugin @RokoCB :: Return the visible amount of px
// of any element currently in viewport.
// stackoverflow.com/questions/24768795/
;(function($, win) {
  $.fn.inViewport = function(cb) {
     return this.each(function(i,el){
       function visPx(){
         var H = $(this).height(),
             r = el.getBoundingClientRect(), t=r.top, b=r.bottom;
         return cb.call(el, Math.max(0, t>0? H-t : (b<H?b:H)));  
       } visPx();
       $(win).on("resize scroll", visPx);
     });
  };
}(jQuery, window));


function changeHeaderStyle() {
  if ($(window).scrollTop() > topPosition) {
    $("#home-navbar").removeClass("transparent-navbar");
  } else {
    $("#home-navbar").addClass("transparent-navbar");
  }
}

$(document).ready(function() {
  changeHeaderStyle();

  $(window).scroll(changeHeaderStyle);
});

$("#scroll-down").click(function(){
  $('html, body').animate({
    scrollTop: $("#section2").offset().top
  }, 1000);
});

$("circle").inViewport(function(px){
    if(px) $(this).addClass("visible") ;
});
</script>
@endsection