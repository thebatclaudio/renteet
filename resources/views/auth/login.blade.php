@extends('layouts.app')

@section('title', 'Accedi')

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
    margin-bottom: 0px;
}
.padded-content p {
    font-size: 2.6em;
}
/* Bottom menu
* --------------------------------------- */
#infoMenu li a {
  color: #fff;
}

.btn-big {
  font-size: 2em;
  padding: 10px 40px;
  background: none;
  color: #000;
  border-color: #000;
  border-width: 3px;
}

.content>form {
    display:block;
    width: 400px;
}

#section4 .btn-big:hover, #section4 .btn-big:focus, #section4 .btn-big:active {
    background-color: #085833;
    border-color: #094e2e;
    box-shadow: 0 0 0 0;
    cursor: pointer;
}

#section4{
    background-image: url(images/bg2.jpg);
    padding: 0;
}
#section4 .padded-content {
    background-color: rgba(19, 142, 83, 0.70);
    color: #fff;
}

.input {
    height: 40px;
}

.btn-link, .btn-link:hover {
    color: #FFF;
}

.padded-content .form-control {
    height: 60px;
    font-size: 20px;
    color: #FFF;
    background-color: #085833;
    border-color: #094e2e;
    box-shadow: 0 0 0 0;
}
</style>
@endsection

@section('content')
<div id="fullpage">
    <div class="section" id="section4">
        <div class="blur">
            <div class="row full-height">
                <div class="col-md-6 offset-md-6 text-left padded-content">
                    <div class="col-md-12">
                        <h3>Accedi a Renteet</h3>
                        <p>Rivoluziona il modo in cui cerchi il tuo alloggio</p>
                    </div>

                    <form class="form-horizontal margin-top-20" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Indirizzo e-mail" required autofocus autocomplete="off">
                
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                        <!--div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ricordami
                                    </label>
                                </div>
                            </div>
                        </div-->
                
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-big">
                                    Accedi
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                    <a class="btn-link" href="{{ route('password.request') }}">
                                        Password dimenticata?
                                    </a>
                            </div>
                        </div>
                    </form>
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
