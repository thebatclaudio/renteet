<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Renteet') }} - @yield('title')</title>
    
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">        <link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet">


        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

        <link rel="stylesheet" href="/css/app.css?{{rand()}}">
        <link rel="stylesheet" href="/css/utilities.css?{{rand()}}">
        <link rel="stylesheet" href="/css/icons.css?{{rand()}}">

        @yield('styles')
    </head>
    <body>
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/it_IT/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <!-- Your customer chat code -->
        <div class="fb-customerchat"
        attribution=setup_tool
        page_id="1545497615573228"
        theme_color="#099154"
        logged_in_greeting="Hai bisogno di aiuto? Chiedi pure"
        logged_out_greeting="Hai bisogno di aiuto? Chiedi pure">
        </div>

        <header>
            <nav class="main-navbar navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{url('/')}}" title="{{ config('app.name', 'Renteet') }} - Home">
                    <img class="logo" src="/images/renteet-logo.png">
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <form id="searchForm" class="form-inline d-none d-sm-inline-flex" action="{{route('search.coordinates')}}" method="GET">
                    <input id="lat" name="lat" type="hidden" required>
                    <input id="lng" name="lng" type="hidden" required>
                    <input id="search-input" name="searchInput" class="form-control" type="text" onFocus="geolocate()" placeholder="Prova &quot;Palermo&quot;" aria-label="Cerca">
                    <i class="search-icon fa fa-search fa-2x" aria-hidden="true"></i>
                </form>

                @include('partials.mobileNav')

                @include('partials.nav')
            </nav>
        </header>
        
        <main role="main">
        @if(\Auth::user())
            @if(\Auth::user()->verified != true)
            <div class="alert alert-warning margin-top-10" role="alert">
                <strong>Ciao {{\Auth::user()->first_name}}!</strong> Hai ancora due giorni per confermare il tuo account con la mail che ti abbiamo inviato.
            </div>
            @endif
        @endif
            @yield('content')

            @include('partials.footer')
        </main>

        @include('cookieConsent::index')

        <script>

        var autocomplete = null;
        var mobileAutocomplete = null;
        function initMap() {
            var input = document.getElementById('search-input');
            var mobileInput = document.getElementById('mobile-search-input');
    
            autocomplete = new google.maps.places.Autocomplete(input);
    
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    return;
                }
        
                var address = '';
                if (place.address_components) {
                    address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                $("#lat").val(place.geometry.location.lat());
                $("#lng").val(place.geometry.location.lng());
                
                $("#searchForm").submit();



            });

            if(mobileInput) {
                mobileAutocomplete = new google.maps.places.Autocomplete(mobileInput);
        
                mobileAutocomplete.addListener('place_changed', function() {
                    var place = mobileAutocomplete.getPlace();
                    if (!place.geometry) {
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        return;
                    }
            
                    var address = '';
                    if (place.address_components) {
                        address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }

                    $("#mobileLat").val(place.geometry.location.lat());
                    $("#mobileLng").val(place.geometry.location.lng());
                
                    $("#mobileSearchForm").submit();

                });
            }
        }

        function geolocate() {
            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
            }
        }
        </script>
        <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAgn7e4Tc95WlmbyqCz71oGDctx3rXf6oQ&libraries=places&callback=initMap"
            async defer></script>

        <script src="//code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>

        <!--script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script-->
        <script src="//js.pusher.com/3.1/pusher.min.js"></script>
        <!--script src="//cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.min.js"></script-->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{url('/js/notify.min.js')}}"></script>

        <!-- Scripts -->
        @yield('scripts')

        <script>
        $(document).ready(function() {

            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    if($(":focus").attr('id') == 'search-input' || $(":focus").attr('id') == 'mobile-search-input'){
                        event.preventDefault();

                        var firstResult = $(".pac-container .pac-item:first").text();

                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({"address":firstResult }, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                var lat = results[0].geometry.location.lat(),
                                    lng = results[0].geometry.location.lng();

                                $("#lat").val(lat);
                                $("#lng").val(lng);
                                $("#search-input").val(results[0].formatted_address);

                                $("#searchForm").submit();
                            }
                        });

                        return false;
                    } else {
                        return true;
                    }
                }
            });
            
            moment.locale('it');
            
            $('.btn-notifications').on('click',function() {
                $.get("{{route('ajax.notifications')}}", function( data ) {
                    var notifications = "";
                    for(notification in data){
                        notifications += '<a class="dropdown-item" href='+data[notification].url+'>';
                        notifications += '<div class="row">';
                        notifications += '<div class="col-auto margin-left-10">';
                        notifications += '<img src='+data[notification].image+' class="rounded-circle img-fluid" style="max-width:60px;">';
                        notifications += '</div>';
                        notifications += '<div class="col">';
                        if(data[notification].read_at != null){
                            notifications +='<p class="grey-color-text">'+data[notification].text;
                        }else{
                            notifications +='<p>'+data[notification].text;
                        }
                        notifications += '<br><small class="grey-color-text text-left date">'+moment.utc(data[notification].created_at, 'x').fromNow()+'</small></p>'
                        notifications += '</div>';
                        notifications += '</div>';
                        notifications += '</a>';
                    }
                    $('#notifications-menu-content').html(notifications);
                    $('.btn-notifications').html('<i class="fas fa-bell"></i>');
                });
            });
        
        });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
    
        @if(\Auth::check())
        @include('partials.notifications')
        @endif

        @if(!env('APP_DEBUG'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123147608-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-123147608-1');
        </script>
        @endif
    </body>
</html>