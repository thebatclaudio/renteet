<script>
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
});

$("#accept-user").on("click", function () {
    var button = $(this);

    var url = '{{route('allow.user', [ 'room' => ':room', 'user' => ':user'])}}';

    swal({
        title: "Sei sicuro di voler accettare la richiesta di adesione?",
        text: "L'operazione non potrà essere annullata",
        buttons: [true, {
            text: 'Approva richiesta',
            closeModal: false
          }]
    })
    .then((send) => {
        if (!send) throw null;
        $.post(url.replace(':room', button.data("room")).replace(':user', {{$user->id}}), function( data ) {
            if(data.status === 'OK') {
                swal("Richiesta di adesione approvata!", "Accogli il tuo nuovo coinquilino inviandogli un messaggio", "success").then(() => { location.reload() });;;
                button.attr('disabled', true);
            }else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
        });    
    })
    .catch(err => {
          if (err) {
              swal("Si è verificato un errore", "Riprova più tardi", "error");  
          } else {
            swal.stopLoading();
            swal.close();
          }
    });
});

$("#refuse-user").on("click", function () {
    var button = $(this);

    var url = '{{route('refuse.user', [ 'room' => ':room', 'user' => ':user'])}}';

    swal({
        title: "Sei sicuro di voler rifiutare la richiesta di adesione?",
        text: "L'operazione non potrà essere annullata",
        buttons: [true, {
            text: 'Rifiuta richiesta',
            closeModal: false
          }]
    })
    .then((send) => {
        if (!send) throw null;
        $.post(url.replace(':room', button.data("room")).replace(':user', {{$user->id}}), function( data ) {
            if(data.status === 'OK') {
                swal("Richiesta di adesione rifiutata!", "", "success").then(() => { location.reload() });;;
                button.attr('disabled', true);
            }else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
        });    
    })
    .catch(err => {
          if (err) {
              swal("Si è verificato un errore", "Riprova più tardi", "error");  
          } else {
            swal.stopLoading();
            swal.close();
          }
    });
});
</script>