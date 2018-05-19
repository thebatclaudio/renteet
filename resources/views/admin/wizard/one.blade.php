@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="progress wizard-progress">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="container margin-top-20">
    <h6 class="step-number">Primo passo</h6>
    <h3 class="step-title">Di che ambiente si tratta?</h3>


    <form class="form-horizontal" method="POST" action="">
        {{ csrf_field() }}
        
        <div class="row">
            <div class="col-md-6">
                <label for="tipologia">Scegli una tipologia</label>
                <select name="tipologia" class="form-control">
                    <option value="-1" disabled selected required>Selezionane una</option>
                    <option value="1">Bella tipologia</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="margin-left" for="address">Inserisci l'indirizzo</label>
                <input id="address" name="address" class="form-control margin-left" type="text" placeholder="Inserisci una via" />
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-md-6">
                <label for="max_guests">Quante persone puoi ospitare?</label>
                <input id="max_guests" name="max_guests" class="form-control" type="number" min="0" default="0" />
            </div>
            <div class="col-md-6">
                <label class="margin-left" for="bedrooms">Quante stanze da letto sono presenti?</label>
                <input id="bedrooms" name="bedrooms" class="form-control margin-left" type="number" min="0" default="0" />
            </div>
        </div>
        
        <div class="actions margin-top-20 text-right">
            <button type="submit" class="btn btn-primary btn-lg">Avanti</button>
        </div>
    </form>

</div>
@endsection