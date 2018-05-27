<script type="text/javascript">
    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('user.{{\Auth::user()->id}}');

    channel.bind('App\\Events\\AdhesionToHouse', function(data) {
        $.notify({
            title: '<strong>'+data.user.first_name+' '+data.user.last_name+'</strong> ha richiesto di accedere ad un tuo immobile',
        }, {
            style: 'notification',
            autoHide: true,
            clickToHide: false,
            autoHideDelay: 15000
        });
    });

    $.notify.addStyle('notification', {
    html: 
        "<div class='notification-container'>" +
            '<div class="alert alert-success" role="alert" style="min-width: 200px">'+
                '<p data-notify-html="title"></p>'+
                '<p><a href="" class="btn btn-primary btn-xs">Visualizza</a><a href="" class="btn btn-default btn-xs close-notify">Chiudi</a></p>'+
            '</div>'+
        "</div>"
    });

    $(document).on('click', '.close-notify', function() {
        $(this).trigger('notify-hide');
    });
</script>