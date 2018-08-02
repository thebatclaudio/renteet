@extends('layouts.app')

@section('title', 'Scopri i vantaggi')

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
            <a class="btn btn-outline-success" href="/scopri-i-vantaggi/locatori" title="Sono un locatore">Sono un locatore</a>
        </div>    
    </div>

    <h1 class="page-title text-center margin-top-40">I vantaggi</h1>
    <h5 class="text-muted text-uppercase text-center">Per gli ospiti</h5>

    <h3 class="margin-top-40">Un'esperienza nuova</h3>

    <p>Il vantaggio più grande di un utente ospite è far parte di qualcosa di nuovo.</p>
    <p>Il design della piattaforma è studiato per sentirsi parte di un grande posto condiviso. </p>
    <p>Crediamo nei rapporti umani, nella potenza di una nuova amicizia, negli stimoli suscitati da una persona nuova. Forti della consapevolezza che un appartamento condiviso genera nuove relazioni umane, abbiamo cercato di applicare a tutto questo un solido modello di mercato.</p>
    <p>L’idea di Renteet è nata in seguito a una condivisione di un appartamento. Accade qualcosa di magico quando le giuste persone si uniscono in una perfetta combinazione.</p>
    <p>La relazione fra i tanti vantaggi di un affitto condiviso e questa esperienza rendono Renteet un posto speciale. </p>

    <h3 class="margin-top-40">Scegli tu chi conoscere</h3> 

    <p>Scegli l’appartamento che fa per te, sfoglia i vari profili, leggi le recensioni e poi spingiti oltre l’apparenza conoscendo quelle persone all’interno dell’appartamento. La varietà di scelta fra persone e immobili e il sistema di recensioni mirano a stimolare fra gli utenti scelte consapevoli.</p>

    <h3 class="margin-top-40">Abbiamo a cuore la privacy dei nostri utenti</h3>

    <p>Poiché l’esperienza Renteet si basa sulle persone all’interno di un immobile, garantire la privacy è stato il primo quesito.</p>
    <p>Il software genera per ogni immobile una posizione approssimata diversa per ogni dispositivo, abbastanza piccola da rendere l’idea sulla posizione dell’immobile ma abbastanza grande da garantire l’anonimato.</p>
    <p>Saranno i locatori a rilasciare privatamente le posizioni agli ospiti attraverso la chat.</p>

    <h3 class="margin-top-40">Supporto legale</h3>

    <p>Se un locatore adotta il contratto di Renteet per gli affitti di lungo periodo potrai consultarlo preventivamente e sarà sempre a tua disposizione.</p>

    <h3 class="margin-top-40">Qualità della piattaforma</h3>

    <p>Dedichiamo un’attenzione maniacale alla qualità del servizio. Con l’aiuto delle segnalazioni degli utenti, garantiremo un servizio privo di comportamenti scorretti o profili falsi.</p>

    <h3 class="margin-top-40">Completa connessione</h3>

    <p>Potrai utilizzare le chat per qualsiasi necessità. Puoi contattare privatamente locatori e inquilini per qualsiasi informazione sull’immobile.</p>

    <h3 class="margin-top-40">Migliorie continue</h3>

    <p>I feedback degli utenti sono il carburante di Renteet.</p>
    <p>Saranno gli utenti, sia gli ospiti che i locatori a decretare l’evoluzione di Renteet. In fin dei conti è sulla loro esperienza che il servizio deve adattarsi.</p>

    <h3 class="margin-top-40">Un organismo in continua crescita</h3>

    <p>Sarà presto disponibile l’app di Renteet, per un contatto più diretto con il proprio immobile. Verranno resi disponibili i pagamenti digitali in favore dei locatori.</p>
    <p>L’IA velocizzerà il mercato poiché Renteet impara dalle persone.</p>
</div>
@endsection