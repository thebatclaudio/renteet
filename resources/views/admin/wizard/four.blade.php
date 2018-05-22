@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Ultimo passo</h6>
    <h3 class="step-title">Definisci le tue priorità</h3>
    <hr>

    <form method="POST" action="{{route('admin.house.wizard.four.save')}}">
        {{ csrf_field() }}

        <h5 class="margin-top-20">Vuoi accettare personalmente gli ospiti?</h5>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="auto_accept" id="autoAcceptFalse" value="false">
            <label class="form-check-label" for="autoAcceptFalse">Si</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="auto_accept" id="autoAcceptTrue" value="true">
            <label class="form-check-label" for="autoAcceptTrue">No</label>
        </div>

        <h5 class="margin-top-40">Qual'&egrave; il genere dei tuoi ospiti?</h5>

        <select class="form-control form-control-lg w-25" name="gender" id="gender">
            <option value="male">Uomo</option>
            <option value="female">Donna</option>
            <option value="mixed">Misto</option>
        </select>

        <h5 class="margin-top-40">Inserisci il numero minimo di mesi di preavviso al recesso (minimo 3 mesi)</h5>

        <div class="form-group">
            <input class="form-control form-control-lg w-25" type="number" min="3" value="3" name="notice_months" placeholder="Mesi di preavviso" required>
        </div>

        <div class="actions margin-top-20 text-right">
            <button type="submit" id="submit-btn" class="btn btn-success btn-lg">Pubblica il tuo annuncio</button>
        </div>
    </form>
</div>
@endsection