@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container">

<h1 class="page-title text-center margin-top-40">FAQ</h1>

<h3 class="margin-top-40">Come iniziare</h3>

<!--Accordion wrapper-->
<div class="accordion margin-top-20" id="comeIniziareAccordion" role="tablist" aria-multiselectable="true">

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingOne">
            <a data-toggle="collapse" data-parent="#comeIniziareAccordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h5 class="mb-0">
                    Cos'è Renteet?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#comeIniziareAccordion">
            <div class="card-body">
                Renteet è una piattaforma che aiuta gli studenti a confrontare immobili condivisi nella zona di loro interesse. Semplifica l’esperienza di ricerca fin dall’inizio attraverso la scelta delle persone con cui convivere. Renteet mira a creare scelte consapevoli e durature anche grazie alle recensioni degli utenti. Lo scopo ultimo è quello di perfezionare il mercato attraverso il soddisfacimento degli interessi del locatore e degli affittuari.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingTwo">
            <a class="collapsed" data-toggle="collapse" data-parent="#comeIniziareAccordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <h5 class="mb-0">
                    Perché renteet è speciale?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#comeIniziareAccordion">
            <div class="card-body">
                Ciò che rende speciale renteet è il sistema innovativo con cui gli utenti interagiscono fra di loro. Lo chiamiamo Blending, combina le persone in un immobile allo scopo di occuparlo nel più breve tempo possibile.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#comeIniziareAccordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <h5 class="mb-0">
                    Sono uno studente e cerco casa, quali sono i miei vantaggi?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#comeIniziareAccordion">
            <div class="card-body">
                Renteet è costruito per offrire la migliore esperienza di ricerca di case condivise sul mercato. Con renteet hai la possibilità di conoscere in anticipo le persone con cui conviverai, potrai leggere le recensioni degli altri utenti che già hanno convissuto con altri basate sull’esperienza avuta. Potrai leggere le recensioni degli appartamenti e/o dei locatori. Potrai abbandonare l’immobile in qualsiasi momento pur rispettando i vincoli stabiliti dal locatori, la piattaforma cercherà di sostituirti con un’altro utente nel più breve tempo possibile.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

	    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#comeIniziareAccordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <h5 class="mb-0">
                    Sono un locatore, quali sono i miei vantaggi?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#comeIniziareAccordion">
            <div class="card-body">
                Nessuno sforzo nella gestione e ricerca degli inquilini,  velocità di occupazione, contratti dinamici e un completo controllo sul proprio immobile sono solo alcuni dei vantaggi del locatore. Ottieni più informazioni dall’apposita sezione.
            </div>
        </div>
    </div>
    <!-- Accordion card -->
</div>
<!--/.Accordion wrapper-->


<h3 class="margin-top-40">Funzionamento</h3>

<!--Accordion wrapper-->
<div class="accordion margin-top-20" id="funzionamentoAccordion" role="tablist" aria-multiselectable="true">

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingOne">
            <a data-toggle="collapse" data-parent="#funzionamentoAccordion" href="#funzionamentoCollapseOne" aria-expanded="true" aria-controls="funzionamentoCollapseOne">
                <h5 class="mb-0">
                    Come posso aderire ad un immobile?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="funzionamentoCollapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#funzionamentoAccordion">
            <div class="card-body">
                Ogni immobile presenterà tanti cerchi quanti sono le persone che può ospitare. Potrai interagire con i profili già occupati, clicca su quelli vuoti per inviare una richiesta di adesione al proprietario dell’immobile. 
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingTwo">
            <a class="collapsed" data-toggle="collapse" data-parent="#funzionamentoAccordion" href="#funzionamentoCollapseTwo" aria-expanded="false" aria-controls="funzionamentoCollapseTwo">
                <h5 class="mb-0">
                    Cosa sono le astine al di sotto dei profili?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="funzionamentoCollapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#funzionamentoAccordion">
            <div class="card-body">
                Le astine simboleggiano le diverse stanze da letto degli immobile in alcuni casi potrai scegliere fra stanze singole o condivise. In quest’ultimo caso all’interno delle astine troverai le persone con cui condividerai l’immobile.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#funzionamentoAccordion" href="#funzionamentoCollapseThree" aria-expanded="false" aria-controls="funzionamentoCollapseThree">
                <h5 class="mb-0">
                    Gli altri utenti possono vedere dove vivo?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="funzionamentoCollapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#funzionamentoAccordion">
            <div class="card-body">
                No, gli altri utenti possono soltanto vedere con chi vivi. Tuteliamo la tua privacy fornendo una posizione approssimata dell’immobile sempre diversa, abbastanza piccola da darti un’idea ma sufficientemente grande da garantire l’anonimato.
            </div>
        </div>
    </div>
    <!-- Accordion card -->
</div>
<!--/.Accordion wrapper-->



<h3 class="margin-top-40">Richiesta di adesione</h3>

<!--Accordion wrapper-->
<div class="accordion margin-top-20" id="RichiestaAccordion" role="tablist" aria-multiselectable="true">

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingOne">
            <a data-toggle="collapse" data-parent="#RichiestaAccordion" href="#RichiestaCollapseOne" aria-expanded="true" aria-controls="RichiestaCollapseOne">
                <h5 class="mb-0">
                    Cos’è una richiesta di adesione?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="RichiestaCollapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#RichiestaAccordion">
            <div class="card-body">
                La richiesta di adesione è una notifica che arriva al locatore, comunica la tua intenzione di voler occupare l’immobile. Il locatore potrà accettarla o rifiutarla.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingTwo">
            <a class="collapsed" data-toggle="collapse" data-parent="#RichiestaAccordion" href="#RichiestaCollapseTwo" aria-expanded="false" aria-controls="RichiestaCollapseTwo">
                <h5 class="mb-0">
                    Che data devo inserire prima di aderire a un immobile?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="RichiestaCollapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#RichiestaAccordion">
            <div class="card-body">
                Inserisci la data in cui pensi che accederai fisicamente all’immobile. Potrà per esempio coincidere con l’inizio del periodo di studi o con qualsiasi altra tua esigenza. Il locatore valuterà quella data prima di accettare o rifiutare la tua richiesta di adesione. La data potrà anche non coincidere con precisione alla realtà, serve soltanto per dare un’idea al locatore delle tue intenzione. Per qualsiasi chiarimento con la controparte puoi usare la chat.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#RichiestaAccordion" href="#RichiestaCollapseThree" aria-expanded="false" aria-controls="RichiestaCollapseThree">
                <h5 class="mb-0">
                    Come posso annullarla?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="RichiestaCollapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#RichiestaAccordion">
            <div class="card-body">
                Quando il locatore accetta o rifiuta ti arriverà una notifica. Prima dell’accettazione o del rifiuto potrai annullare la tua richiesta la quale risulterà in sospeso. 
            </div>
        </div>
    </div>
    <!-- Accordion card -->

	<!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#RichiestaAccordion" href="#RichiestaCollapseFour" aria-expanded="false" aria-controls="RichiestaCollapseFour">
                <h5 class="mb-0">
                    Se il locatore accetta posso annullare la mia richiesta?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="RichiestaCollapseFour" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#RichiestaAccordion">
            <div class="card-body">
                Si, a patto che lo comunichi al proprietario così che possa eliminare il tuo profilo dal suo immobile. Renteet crea un posto di incontro fra locatori e inquilini. Non sarai ufficialmente un condutture finché non firmi il contatto insieme al locatore.
            </div>
        </div>
    </div>
    <!-- Accordion card -->


	<!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#RichiestaAccordion" href="#RichiestaCollapseFive" aria-expanded="false" aria-controls="RichiestaCollapseFive">
                <h5 class="mb-0">
                    Se la richiesta rimane in sospeso per troppo tempo?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="RichiestaCollapseFive" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#RichiestaAccordion">
            <div class="card-body">
                Cercheremo di sollecitare la riposta del locatore ma se dovesse tardare per più di una settimana la richiesta verrà annullata.
            </div>
        </div>
    </div>
    <!-- Accordion card -->
</div>
<!--/.Accordion wrapper-->



<h3 class="margin-top-40">Abbandonare l'immobile</h3>

<!--Accordion wrapper-->
<div class="accordion margin-top-20" id="abbandonoAccordion" role="tablist" aria-multiselectable="true">

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingOne">
            <a data-toggle="collapse" data-parent="#abbandonoAccordion" href="#abbandonoCollapseOne" aria-expanded="true" aria-controls="abbandonoCollapseOne">
                <h5 class="mb-0">
                    Come posso abbandonare l’immobile?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="abbandonoCollapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#abbandonoAccordion">
            <div class="card-body">
                Chiaramente prima di abbandonare l’immobile su renteet è consigliabile comunicare il recesso al locatore. L’abbandono su renteet serve soltanto per sostituirti con un altro inquilino. Ricorda che per recedere da un immobile devi sempre rispettare i termini del contratto di locazione pattuito con il locatore.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingTwo">
            <a class="collapsed" data-toggle="collapse" data-parent="#abbandonoAccordion" href="#abbandonoCollapseTwo" aria-expanded="false" aria-controls="abbandonoCollapseTwo">
                <h5 class="mb-0">
                    Quando comunico la mia intenzione di abbandonare?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="abbandonoCollapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#abbandonoAccordion">
            <div class="card-body">
                Trenta giorni prima del tuo abbandono verrà data la possibilità ad altri utenti di prenotare il tuo posto. Il nuovo coinquilino ti sostituirà soltanto dopo che il tuo soggiorno nell’immobile è terminato. Lo scopo è quello di diminuire il tempo di sostituzione.
            </div>
        </div>
    </div>
    <!-- Accordion card -->

    <!-- Accordion card -->
    <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree">
            <a class="collapsed" data-toggle="collapse" data-parent="#abbandonoAccordion" href="#abbandonoCollapseThree" aria-expanded="false" aria-controls="abbandonoCollapseThree">
                <h5 class="mb-0">
                    Sono un locatore, il mio ospite recederà fra venti giorni ma voglio rendere disponibile il mio immobile, come faccio?
                </h5>
            </a>
        </div>

        <!-- Card body -->
        <div id="abbandonoCollapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#abbandonoAccordion">
            <div class="card-body">
                Se il tuo ospite ti ha comunicato la sua intenzione di recedere ma non ha ancora abbandonato l’immobile su renteet potrai farlo tu stesso dalla sezione “Gestisci le mie case”. Ti verrà chiesto quando vuoi che l’immobile sia reso disponibile, a partire dalla data che inserirai il tuo immobile ritornerà visibile sei risultati di ricerca.  
            </div>
        </div>
    </div>
    <!-- Accordion card -->
</div>
<!--/.Accordion wrapper-->

</div>
@endsection