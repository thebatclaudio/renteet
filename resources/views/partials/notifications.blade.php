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

    channel.bind('App\\Events\\AdhesionAcceptance', function(data) {

        console.log(data);

        $.notify({
            title: '<strong>'+data.owner.first_name+' '+data.owner.last_name+'</strong> ha accettato la tua richiesta di adesione per l\'immobile <strong>'+data.house.name+'</strong>',
            image: '<img class="img-circle" height="80" width="80" src="'+data.owner.profile_pic+'">',
            profileLink: '<a href="'+data.house.url+'" class="btn btn-primary btn-xs">Visualizza l\'immobile</a>'
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

<script>
$("#btn-notifications").on('click', function() {
    $.get('{{route("ajax.notifications")}}', function (data) {
        html = "";
        for(var i in data) {
            html+= '<a href="'+data[i].url+'" class="dropdown-item notification-item"><img src="'+data[i].image+'" class="profile-pic"> '+data[i].text+'</a>'
        }
        $("#notifications-menu-content").html(html);
    });
});
</script>