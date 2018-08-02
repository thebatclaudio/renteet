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
            <a class="btn btn-outline-success" href="/scopri-i-vantaggi" title="Sono un ospite">Sono un ospite</a>
            <a class="btn btn-success" href="#" title="Sono un locatore">Sono un locatore</a>
        </div>    
    </div>

    <h1 class="page-title text-center margin-top-40">I vantaggi</h1>
    <h5 class="text-muted text-uppercase text-center">Per i locatori</h5>

    <h3 class="margin-top-40">Lascia che sia Renteet a fare il lavoro</h3>
 
    <p>Renteet si è evoluto sulle inefficienze del mercato. Crediamo che i rendimenti degli immobili possano essere ottimizzati dividendo la quota d’affitto in più parti.</p>
    <p>Tuttavia il mercato degli affitti condivisi è complesso, vi sono molti interessi in ballo. Il nostro compito è soddisfarli generando una nuova esperienza sociale.</p>
    <p>Crea il tuo annuncio, esso sarà arricchito dagli elementi più curiosi in natura: le persone. Il tuo immobile sarà la cornice delle persone che stanno al suo interno. Stimolando la curiosità degli utenti ridurremo al minimo i tempi di attesa per la totale occupazione del tuo immobile.</p>
    <p>Ottimizziamo la ricerca continuamente, con l’introduzione dell’intelligenza artificiale ogni ricerca sarà personalizzata per l’utente che la sta effettuando, il tutto a vantaggio della velocità d’affitto.</p>
    <p>Il nostro scopo è garantirti il massimo rendimento e i tempi di attesa più bassi del mercato. Renteet si evolverà sul mercato continuamente, garantendo una piattaforma sempre più divertente e funzionale.</p>

    <h3 class="margin-top-40">Il tuo immobile è nelle tue mani</h3>

    <p>Ogni locatore detterà le proprie condizioni d’affitto. Stabilirai il preavviso al recesso, il genere dei tuoi ospiti, accetta personalmente ogni richiesta di adesione, stabilisci il tempo minimo e/o massimo di affitto e tanto altro.</p>

    <h3 class="margin-top-40">Contratti Dinamici</h3>

    <p>Ogni locatore avrà la possibilità di utilizzare i contratti offerti da renteet. Sono dei contratti dinamici con i quali si è coperti un’anno. Essi variano con il variare dei coinquilini. Sono compilati dal locatore e possono essere modificati in ogni tempo, grazie alle guide e alle aree precompilate i contratti saranno sempre a norma di legge.</p>

    <h3 class="margin-top-40">Non temere il recesso dei tuoi ospiti</h3>

    <p>Quando uno dei tuoi ospiti recederà dall’immobile esso risulterà subito visibile.</p>
    <p>Grazie alle precedenti esperienze, alle descrizioni e agli interessi degli utenti ci è possibile prevedere le preferenze degli ospiti. Il posto del recedente verrà subito visualizzato dagli utenti ideali. Così da sostituire il tuo ospite fin dal primo giorno di disponibilità.</p>

    <h3 class="margin-top-40">Flessibilità</h3>

    <p>Il mercato degli affitti della tua città può variare a secondo del periodo dell’anno. Renteet è la piattaforma ideale per sperimentare questi cambiamenti. Puoi optare per affitti di lungo periodo per tutto l’anno o per una parte di esso, oppure puoi offrire affitti di breve periodo o entrambi contemporaneamente. Puoi infine utilizzare alcune stanze per affitti di lungo periodo e altre per affitti di breve periodo. La flessibilità come mezzo di ottimizzazione dei rendimenti annuali.</p>

    <h3 class="margin-top-40">Stretta collaborazione</h3>

    <p>Renteet non funziona senza locatori. I locatori che adottano il nostro sistema non diventano clienti ma partner. Possono contattarci in ogni momento e chiedere la nostra consulenza per l’inserimento dell’annuncio (servizio di shooting dell’appartamento e compilazione della descrizione). Il tutto sarà gratuito.</p>

    <h3 class="margin-top-40">Migliorie continue</h3>

    <p>I feedback degli utenti sono il carburante di renteet.</p>
    <p>Saranno gli utenti, sia gli ospiti che i locatori a decretare l’evoluzione di renteet. In fin dei conti è sulla loro esperienza che il servizio deve adattarsi.</p>

    <h3 class="margin-top-40">I migliori locatori verranno premiati</h3>

    <p>Un rapporto di locazione andato a buon fine o il carattere del locatore lasceranno un segno su renteet. Il sistema delle recensioni migliorerà la piattaforma e favoreggerà i locatori migliori.</p>

    <h3 class="margin-top-40">Dati di mercato</h3>

    <p>Su renteet saranno disponibili ampi dati di mercato della città in cui è ubicato il proprio immobile. Prezzo di affitto medio nella zona di riferimento, andamento dei prezzi in un determinato periodo, quante persone visualizzano il proprio immobile e quante lo salvano fra i preferiti. Questi e tanti altri dati saranno a disposizione del locatore nell’area business per consentire la competitività del proprio immobile rispetto agli altri.</p>

    <h3 class="margin-top-40">Un organismo in continua crescita</h3>

    <p>Sarà presto disponibile l’app di renteet, per un contatto più diretto con il proprio immobile. Verranno resi disponibili i pagamenti digitali in favore dei locatori.</p>
    <p>L’IA velocizzerà il mercato poiché renteet impara dalle persone.</p>
</div>
@endsection