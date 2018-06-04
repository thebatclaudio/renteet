<script type="text/javascript">
    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('user.{{\Auth::user()->id}}');

    channel.bind('App\\Events\\AdhesionToHouse', function(data) {

        console.log(data);

        $.notify({
            title: '<strong>'+data.user.first_name+' '+data.user.last_name+'</strong> ha richiesto di accedere a <strong>'+data.house.name+'</strong>',
            image: '<img class="img-circle" height="80" width="80" src="'+data.user.profile_pic+'">',
            profileLink: '<a href="'+data.user.profile_url+'" class="btn btn-primary btn-xs">Visualizza profilo</a>'
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
                '<div class="row">'+
                '<div class="col-sm-3" data-notify-html="image"></div><div class="col-sm-9">'+
                '<p data-notify-html="title"></p>'+
                '<p><span data-notify-html="profileLink"></span><a href="" class="btn btn-default btn-xs close-notify">Chiudi</a></p>'+
            '</div>'+
        "</div>"
    });

    $(document).on('click', '.close-notify', function() {
        $(this).trigger('notify-hide');
    });
</script>