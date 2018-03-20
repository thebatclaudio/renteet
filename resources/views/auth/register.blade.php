@extends('layouts.app')

@section('title', 'Registrati')

@section('styles')
<link rel="stylesheet" href="/css/tempusdominus-bootstrap-4.min.css" />
@endsection

@section('scripts')
<script type="text/javascript" src="/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/js/tempusdominus-bootstrap-4.min.js"></script>
@endsection

@section('content')
<div class="register container">
    <h1>Unisciti a Renteet</h1>
    <h4 class="text-muted">Rivoluziona il modo in cui cerchi il tuo alloggio</h4>

    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label">Nome</label>

            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="col-md-4 control-label">Cognome</label>

            <div class="col-md-6">
                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Indirizzo E-mail</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            <label for="birthday" class="col-md-4 control-label">Data di nascita</label>

            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-3">
                        <select name="day" class="form-control">
                            <option disabled selected value="-1">Giorno:</option>
                            @for($i=1;$i<=31;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="month" class="form-control">
                                <option disabled selected value="-1">Mese:</option>
                                <option value="1">Gennaio</option>
                                <option value="2">Febbraio</option>
                                <option value="3">Marzo</option>
                                <option value="4">Aprile</option>
                                <option value="5">Maggio</option>
                                <option value="6">Giugno</option>
                                <option value="7">Luglio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Settembre</option>
                                <option value="10">Ottobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Dicembre</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="year" class="form-control">
                            <option disabled selected value="-1">Anno:</option>
                            @for($i=(int)date("Y")-18;$i>(int)date("Y")-118;$i--)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                @if ($errors->has('birthday'))
                    <span class="help-block">
                        <strong>{{ $errors->first('birthday') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Crea una Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-md-4 control-label">Conferma Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <input type="checkbox" id="condition" name="condition">
                <label for="condition" class="control-label">Ho letto e accetto i <a href="#">termini e le condizioni di utilizzo</a></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Registrati
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
