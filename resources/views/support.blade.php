@extends('layouts.app')

@section('title', 'support')

@section('styles')
<link rel="stylesheet" href="/css/support.css?{{rand()}}">
@endsection

@section('content')
<div id="support-wrapper">
    <div class="card support-box">

        <h3 class="text-center">Support</h3>

        @if ($errors->any())
            <div class="alert alert-danger padding-10">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success padding-10">
                {{ Session::get('success') }}
            </div>
        @endif

        <form class="form-horizontal margin-top-20" method="POST" action="{{ route('support.send') }}">
            {{ csrf_field() }}

            <div class="form-group padding-10 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{\Auth::user()->email}}">
                </div>
            </div>

            <div class="form-group padding-10 row">
                <label for="selectType" class="col-sm-3 col-form-label">Tipo di segnalazione</label>
                <select class="form-control col-sm-7" id="selectType" name="type">
                    @foreach($supportTypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group padding-10 row">
                <label for="message" class="col-sm-2 col-form-label">Message</label>
                <div class="col-sm-9">
                    <textarea name="message" class="form-control" id="message" rows="8" maxlength="300" placeholder="Scrivi qui il tuo messaggio"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <button type="submit" class="btn btn-success btn-login btn-block">
                        Invia
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection