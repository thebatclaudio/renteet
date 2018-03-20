@extends('layouts.app')

@section('title', 'Be friendly')

@section('styles')
<style>
/* Style for our header texts
* --------------------------------------- */
h1, h2, h3{
  margin:0;
  padding:0;
}
/* Centered texts in each section
* --------------------------------------- */
.section{
  text-align:center;
}
/* Backgrounds will cover all the section
* --------------------------------------- */
.section{
  background-size: cover;
  background-position: center center;
}
.slide{
  background-size: cover;
  background-position: center center;
}
/* Defining each section background and styles
* --------------------------------------- */
#section0{
  background-image: url(images/bg1.jpg);
}
.blur {
  height: 100%;
  background-color: rgba(0, 0, 0, 0.2);
}
.padded-content {
  padding: 120px;
}
.content {
  top: 50%;
  transform: translateY(-50%);
  position: relative;
}
.content h1 {
  color: #FFF;
  font-size: 12em;
}
.full-height {
  height: 100%;
}
.padded-content {
  background-color: #FFF;
  color: #000;
}
.padded-content h3 {
  font-size: 4em;
  margin-bottom: 40px;
}
.padded-content h3 {
  font-size: 4em;
  margin-bottom: 40px;
}
.padded-content p {
  font-size: 2.6em;
}
#section2{
  background-image: url(images/bg2.jpg);
  padding: 0;
}
#section2 .padded-content {
  background-color: rgba(254, 211, 127, 0.70);
}
#section3{
  background-image: url(images/bg3.jpg);
  padding: 0;
}
#section3 .padded-content {
  background-color: rgba(253, 127, 124, 0.70);
  color: #000;
}
#section4{
  background-image: url(images/bg2.jpg);
  padding: 0;
}
#section4 .padded-content {
  background-color: rgba(19, 142, 83, 0.70);
  color: #fff;
}
/*Adding background for the slides
* --------------------------------------- */
#slide1{
  background-image: url(images/bg4.jpg);
  padding: 0;
}
#slide2{
  background-image: url(images/bg5.jpg);
  padding: 0;
}
/* Bottom menu
* --------------------------------------- */
#infoMenu li a {
  color: #fff;
}

.btn-big {
  font-size: 2em;
  padding: 10px 40px;
  margin-top: 20px;
  background: none;
  color: #000;
  border-color: #000;
  border-width: 3px;
}
  

#section2 .btn-big:hover, #section2 .btn-big:focus, #section2 .btn-big:active {
  background-color: #e69800;
  border-color: #dc9100;
  box-shadow: 0 0 0 0;
}

#section3 .btn-big:hover, #section3 .btn-big:focus, #section3 .btn-big:active {
  background-color: #ab3c5f;
  border-color: #9e3f5d;
  box-shadow: 0 0 0 0;
}

#section4 .btn-big:hover, #section4 .btn-big:focus, #section4 .btn-big:active {
  background-color: #085833;
  border-color: #094e2e;
  box-shadow: 0 0 0 0;
}
</style>
@endsection

@section('content')
<div id="fullpage">
  <div class="section" id="section0">
    <div class="blur">
      <div class="content">
        <img id="homepage-logo" src="/images/renteet-logo.png">
        <h1>renteet</h1>
      </div>
    </div>
  </div>
  <div class="section" id="section2">
    <div class="blur">
      <div class="row full-height">
        <div class="col-md-6 offset-md-6 text-left padded-content">
          <h3>Trova la tua casa, oppure condividila!</h3>
          <p>Condividi la tua casa con persone con i tuoi stessi interessi e cambia il tuo modo di vivere la vita da fuori sede!</p>
          <a href="/register" title="Registrati" class="btn btn-big btn-primary">Scopri di più</a>
        </div>
      </div>
    </div>
  </div>
  <div class="section" id="section3">
    <div class="blur">
      <div class="row full-height">
        <div class="col-md-6 text-left padded-content">
          <h3>Affitta la tua casa</h3>
          <p>Se possiedi una casa per studenti <strong>Renteet</strong> ti aiuterà a tenere sotto controllo i tuoi immobili.<br>Migliora l'occuppancy e aumenta i tuoi profitti.</p>
          <a href="/register" title="Registrati" class="btn btn-big btn-primary">Scopri di più</a>
        </div>
      </div>
    </div>
  </div>
  <div class="section" id="section4">
    <div class="blur">
      <div class="row full-height">
        <div class="col-md-6 offset-md-6 text-left padded-content">
          <h3>Trova i tuoi coinquilini ideali</h3>
          <p>Se sei uno studente fuori sede e cerchi una casa da condividere iscriviti subito ed entra nella community di <strong>Renteet</strong>.</p>
          <a href="/register" title="Registrati" class="btn btn-big btn-primary">Scopri di più</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#fullpage').fullpage({
      verticalCentered: false
    });
  });
</script>
@endsection