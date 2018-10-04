<script type="text/javascript">
    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('user.{{\Auth::user()->id}}');

    channel.bind('App\\Events\\AdhesionToHouse', function(data) {

        $.notify({
            title: '<strong>'+data.user.first_name+' '+data.user.last_name+'</strong> ha richiesto di accedere a <strong>'+data.house.name+'</strong>',
            image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.user.profile_pic+'">',
            profileLink: '<a href="'+data.user.profile_url+'" class="btn btn-elegant btn-sm">Visualizza profilo</a>'
        }, {
            style: 'notification',
            autoHide: false,
            clickToHide: false,
            autoHideDelay: 15000,
            globalPosition: 'bottom right',
        });
    });

    channel.bind('App\\Events\\AdhesionAcceptance', function(data) {

        $.notify({
            title: '<strong>'+data.owner.first_name+' '+data.owner.last_name+'</strong> ha accettato la tua richiesta di adesione per l\'immobile <strong>'+data.house.name+'</strong>',
            image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.owner.profile_pic+'">',
            profileLink: '<a href="'+data.house.url+'" class="btn btn-elegant btn-sm">Visualizza l\'immobile</a>'
        }, {
            style: 'notification',
            autoHide: false,
            clickToHide: false,
            autoHideDelay: 15000,
            globalPosition: 'bottom right',
        });
    });

    channel.bind('App\\Events\\Refused', function(data) {

        $.notify({
            title: '<strong>'+data.owner.first_name+' '+data.owner.last_name+'</strong> ha rifiutato la tua richiesta di adesione per l\'immobile <strong>'+data.house.name+'</strong>',
            image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.owner.profile_pic+'">',
            profileLink: ''
        }, {
            style: 'notification',
            autoHide: false,
            clickToHide: false,
            autoHideDelay: 15000,
            globalPosition: 'bottom right',
        });
    });
    
    channel.bind('App\\Events\\ExitFromHouse', function(data) {

        $.notify({
            title: '<strong>'+data.user.first_name+' '+data.user.last_name+'</strong> ha abbandonato il tuo immobile <strong>'+data.house.name+'</strong>. Seleziona la data in cui tornerà disponibile.',
            image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.user.profile_pic+'">',
            profileLink: '<a href="'+data.house.admin_url+'" class="btn btn-elegant btn-sm">Gestisci il tuo immobile</a>'
        }, {
            style: 'notification',
            autoHide: false,
            clickToHide: false,
            autoHideDelay: 15000,
            globalPosition: 'bottom right',
        });
    });

    channel.bind('App\\Events\\RemovedFromHouse', function(data) {

        $.notify({
            title: '<strong>'+data.owner.first_name+' '+data.owner.last_name+"</strong> ti ha rimosso dall'immobile <strong>"+data.house.name+'</strong>',
            image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.owner.profile_pic+'">',
            profileLink: '<a href="{{url('/house')}}" class="btn btn-elegant btn-sm">Vai alla tua casa</a>'
        }, {
            style: 'notification',
            autoHide: false,
            clickToHide: false,
            autoHideDelay: 15000,
            globalPosition: 'bottom right',
        });
    });

    channel.bind('App\\Events\\ReviewReceived', function(data) {

        if(data.review.lessor == 1){
            $.notify({
                title: '<strong>'+data.from_user.first_name+' '+data.from_user.last_name+"</strong> ti ha lasciato una recensione per l'appartamento <strong>"+data.house.name+'</strong>',
                image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.from_user.profile_pic+'">',
                profileLink: '<a href="'+data.from_user.profile_url+'" class="btn btn-elegant btn-sm">Visualizza profilo</a>'
            }, {
                style: 'notification',
                autoHide: false,
                clickToHide: false,
                autoHideDelay: 15000,
                globalPosition: 'bottom right',
            });
        }else{
            $.notify({
                title: '<strong>'+data.from_user.first_name+' '+data.from_user.last_name+'</strong> ti ha lasciato una recensione',
                image: '<img class="img-flud rounded-circle" height="80" width="80" src="'+data.from_user.profile_pic+'">',
                profileLink: '<a href="'+data.from_user.profile_url+'" class="btn btn-elegant btn-sm">Visualizza profilo</a>'
            }, {
                style: 'notification',
                autoHide: false,
                clickToHide: false,
                autoHideDelay: 15000,
                globalPosition: 'bottom right',
            });
        }
    });

    channel.bind('App\\Events\\MessageReceived', function(data) {
        if("{{\Route::currentRouteName()}}" != "chat.show"){
            $('#counterMessages').fadeIn();
            var counter = $('#counterMessages').text();
            $('#counterMessages').text(parseInt(counter)+1);
            $('#badge-messages').text(parseInt(counter)+1);
            $('#newMessageBadge').fadeIn();
        }
    });

    $.notify.addStyle('notification', {
    html: 
        '<div><div class="notification-container card">'+
            '<div class="row">'+
                '<div class="col-auto" data-notify-html="image"></div>'+
                '<div class="col">'+
                    '<p data-notify-html="title"></p>'+
                    '<p><span data-notify-html="profileLink"></span><a href="" class="btn btn-outline-elegant btn-sm close-notify">Chiudi</a></p>'+
                '</div>'+
            '</div>'+
        '</div>'
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
            html+= '<a href="'+data[i].url+'" class="dropdown-item notification-item"><img src="'+data[i].image+'" class="profile-pic"> '+data[i].text+'</a>';
        }
        $("#notifications-menu-content").html(html);
    });
});
</script>