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
            <a class="btn btn-success" href="/come-funziona" title="Sono un ospite">Sono un ospite</a>
            <a class="btn btn-primary" href="#" title="Sono un locatore">Sono un locatore</a>
        </div>    
    </div>

    <h1 class="page-title text-center margin-top-40">Come funziona?</h1>
    <h5 class="text-muted text-uppercase text-center">Locatori</h5>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <img src="/images/come-funziona/locatori-1.jpg" class="img-fluid" data-aos="zoom-in-right">
        </div>
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-left">
                            <h3>Il tuo immobile è nelle tue mani.</h3>

                            <p class="margin-top-20">La creazione dell’annuncio è facile e intuitiva.</p>

                            <p>Decidi il genere dei tuoi ospiti, se ammettere animali o meno oppure il tempo di preavviso al recesso, queste ed altre priorità saranno spettabili quando vuoi.</p>

                            <p>Potrai decidere se usare o meno il contratto d’affitto standard di <strong class="text-lowercase">Renteet</strong>.</p>
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
                            <h3>Accetta i tuoi ospiti </h3>

                            <p class="margin-top-20">Quando un utente intende affittare una stanza nel tuo appartamento ti invierà una richiesta di adesione.</p>

                            <p>Fornisci e informazioni o pianifica l’incontro con l’ospite tramite chat.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <img src="/images/come-funziona/locatori-2.jpg" class="img-fluid" data-aos="zoom-in-left">
        </div>
    </div>


    <div class="row margin-top-80">
        <div class="col-sm-6">
            <img src="/images/come-funziona/locatori-3.jpg" class="img-fluid" data-aos="zoom-in-right">
        </div>
        <div class="col-sm-6">
            <table style="height: 100%;">
                <tbody>
                    <tr>
                        <td class="align-middle" data-aos="slide-left">
                            <h3>Ottimizza il tempo di sostituzione dei tuoi ospiti.</h3>

                            <p class="margin-top-20">Quando un ospite abbandonerà l’immobile riceverai una notifica con la data di abbandono.</p>

                            <p>Potrai far tornare disponibile il tuo immobile trenta giorni prima dell’effettivo abbandono. Consentendo ad altri utenti di prenotarsi, così da sostituire l’inquilino uscente fin dal primo giorno dell’avvenuto abbandono.</p>
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
                            <h3>Ricorda che la posizione esatta del tuo immobile non sarà visibile.</h3>

                            <p class="margin-top-20">Per tutelare la privacy dei tuoi ospiti la precisa posizione del tuo immobile non sarà resa disponibile.</p>

                            <p>Sarai tu a fornire all’ospite il numero civico e l’indirizzo, soltanto dopo che egli abbia mostrato interesse.</p>
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