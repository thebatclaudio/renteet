@extends('layouts.app')

@section('title', 'Accedi')

@section('link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<div id="login-wrapper">
    <div class="card login-box">

        <h3 class="text-center">Accedi</h3>

        <form class="form-horizontal margin-top-20" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Indirizzo e-mail" required autofocus autocomplete="off">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-12">
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
                <div class="col-md-12 col-md-offset-4">
                    <button type="submit" class="btn btn-success btn-login btn-block">
                        Accedi
                    </button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                        <a class="btn-link" href="{{ route('password.request') }}">
                            Hai dimenticato la password?
                        </a>
                </div>
            </div>

            <hr>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    Non hai ancora un account?
                        <a class="btn-link" href="{{ url('/register') }}">
                            Registrati
                        </a>
                </div>
            </div>

            <hr>

            <div class="form-group text-center">
                <span class="text-uppercase"><small>oppure</small></span>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <a class="btn btn-fb btn-block" href="/facebook/redirect"><i class="fab fa-facebook-f pr-1"></i> Accedi con Facebook</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
@if(session('success'))
swal('Il tuo account è stato verificato', 'Adesso puoi effettuare l\'accesso', 'success');
@elseif(session('error'))
swal('Si è verificato un errore', 'Riprova più tardi', 'error');
@elseif(session('unverified'))
swal('Account non verificato', 'Verifica il tuo account cliccando sul pulsante contenuto nell\'email che hai ricevuto', 'warning');
@endif
</script>
@endsection