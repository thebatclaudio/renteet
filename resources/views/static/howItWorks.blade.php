@extends('layouts.app')

@section('title', 'Come funziona')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.3/aos.css">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.3/aos.js"></script>
<script>
AOS.init();
</script>
@endsection

@section('content')
<div class="container margin-top-20">

    <div class="text-center">
        <div class="btn-group" role="group" aria-label="Ospite / Locatore">
            <a class="btn btn-success" href="#" title="Sono un ospite">Sono un ospite</a>
            <a class="btn btn-outline-success" href="/come-funziona/locatori" title="Sono un locatore">Sono un locatore</a>
        </div>    
    </div>

    <h1 class="page-title text-center margin-top-40">Come funziona?</h1>
    <h5 class="text-muted text-uppercase text-center">Ospiti</h5>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <img src="/images/come-funziona/ospiti-1.jpg" class="img-fluid" data-aos="zoom-in-right">
        </div>
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-left">
                            <h3>Non solo dove, ma con chi vivrai.</h3>

                            <p class="margin-top-20">Scopri le persone con cui convivrai cliccando sul loro profilo.</p>

                            <p>Cliccando sul cerchio vuoto invierai una richiesta di adesione al proprietario dell’immobile.</p>

                            <p>Le astine al di sotto dei profili simboleggiano le stanze all’interno dell’immobile. Esse ospiteranno tante persone quante sono i posto all’interno delle astine.
                            In questo caso puoi scegliere una stanza condivisa o una singola.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-right">
                            <h3>Il proprietario potrà accettare o rifiutare la richiesta di adesione all’immobile.</h3>

                            <p class="margin-top-20">Inserisci la data in cui inizierai il soggiorno e aspetta che il locatore accetti la tua richiesta.</p>

                            <p>Quando l’immobile sarà del tutto occupato non risulterà più visibile nei risultati di ricerca.</p>

                            <p>Potrai interagire con l’immobile in cui vivi in qualsiasi momento dalla sezione “La mia casa”.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <img src="/images/come-funziona/ospiti-2.jpg" class="img-fluid" data-aos="zoom-in-left">
        </div>
    </div>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <img src="/images/come-funziona/ospiti-3.jpg" class="img-fluid" data-aos="zoom-in-right">
        </div>
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-left">
                            <h3>Potrai abbandonare l'immobile in qualsiasi momento.</h3>

                            <p class="margin-top-20">Inserisci la data in cui hai intenzione di abbandonare l’immobile, nel rispetto dei termini di preavviso al recesso stabiliti dal locatore.</p>

                            <p>Il posto tornerà disponibile e verrai sostituito nel più breve tempo possibile.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-right">
                            <h3>Nessuno saprà mai dove abiti.</h3>

                            <p class="margin-top-20">Ogni immobile disponibile su renteet presenta una posizione approssimata.</p>

                            <p>Abbastanza piccola da far intuire la posizione ma abbastanza grande da garantire l’anonimato.</p>

                            <p>Sarà il locatore a comunicarti privatamente la posizione esatta.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <img src="/images/come-funziona/ospiti-4.jpg" class="img-fluid" data-aos="zoom-in-left">
        </div>
    </div>
</div>
@endsection