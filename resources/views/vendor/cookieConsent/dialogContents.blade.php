<div class="js-cookie-consent cookie-consent">
    <div class="row">
        <div class="col">
            <span class="cookie-consent__message">
                {{--!! trans('cookieConsent::texts.message') !!--}}
                Questo sito fa uso di cookie per migliorare l’esperienza di navigazione degli utenti e per raccogliere informazioni sull’utilizzo del sito stesso. Utilizziamo sia cookie tecnici sia cookie di parti terze per inviare messaggi promozionali sulla base dei comportamenti degli utenti. Può conoscere i dettagli consultando la nostra <a href="{{url('/privacy-policy')}}" title="Renteet - Privacy Policy" target="_blank">privacy policy</a>. Proseguendo nella navigazione si accetta l’uso dei cookie; in caso contrario è possibile abbandonare il sito.
            </span>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary btn-sm js-cookie-consent-agree cookie-consent__agree">
                {{-- trans('cookieConsent::texts.agree') --}}
                Accetto
            </button>
        </div>
    </div>
</div>
