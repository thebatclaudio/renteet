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
        showCancelButton: true,
        confirmButtonText: 'Approva richiesta'
    })
    .then((send) => {
        if (send.value) {
            $.post(url.replace(':room', button.data("room")).replace(':user', {{$user->id}}), function( data ) {
                if(data.status === 'OK') {
                    swal("Richiesta di adesione approvata!", "Accogli il tuo nuovo coinquilino inviandogli un messaggio", "success");
                    button.attr('disabled', true);
                }
            });
        }
    });
});
</script>