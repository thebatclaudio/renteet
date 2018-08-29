@extends('layouts.app')

@section('title', 'Segnala un problema')

@section('styles')
<link rel="stylesheet" href="/css/support.css?{{rand()}}">
@endsection

@section('content')
<div class="container">

    @if(Session::has('success'))
        <div class="alert alert-success padding-10 margin-top-20">
            {{ Session::get('success') }}
        </div>
    @endif
    
    @if(Session::has('error'))
        <div class="alert alert-danger padding-10 margin-top-20">
            {{ Session::get('error') }}
        </div>
    @endif

    <h1 class="page-title margin-top-20">Segnala un problema</h1>

    @if ($errors->any())
        <div class="alert alert-danger padding-10">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal margin-top-20" method="POST" action="{{ route('support.send') }}">
        {{ csrf_field() }}

        <!--div class="form-group padding-10 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{\Auth::user()->email}}">
            </div>
        </div-->

        <div class="form-group padding-10 row">
            <label for="selectType" class="col-sm-2 col-form-label">Tipo di problema</label>
            <div class="col-sm-6">
                <select class="form-control" id="selectType" name="type">
                    @foreach($supportTypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group padding-10 row">
            <label for="message" class="col-sm-2 col-form-label">Message</label>
            <div class="col-sm-6">
                <textarea name="message" class="form-control" id="message" rows="8" maxlength="300" placeholder="Scrivi qui il tuo messaggio"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success btn-login">
                        Invia
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection