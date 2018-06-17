@extends('layouts.app')

@section('title', 'Accedi')

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

        </form>
    </div>
</div>
@endsection