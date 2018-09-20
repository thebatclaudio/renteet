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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

        <link rel="stylesheet" href="/css/app.css?{{rand()}}">
        <link rel="stylesheet" href="/css/utilities.css?{{rand()}}">

        @yield('styles')
    </head>
    <body>

        <header>
            <nav id="home-navbar" class="transparent-navbar navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{url('/')}}" title="{{ config('app.name', 'Renteet') }} - Home">
                    <img class="logo" src="/images/renteet-logo.png">
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto d-block d-sm-none">
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Iscriviti</a></li>
                    </ul>
                </div>

                <ul class="navbar-nav mr-auto d-none d-sm-flex flex-row-reverse">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Iscriviti</a></li>
                </ul>
            </nav>
        </header>
        
        <main role="main">
            @yield('content')

            <!-- FOOTER -->
            <!--footer class="container">
                <p class="float-right"><a href="#">Torna su</a></p>
                <p>&copy; {{date('Y')}} Renteet, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
            </footer-->

        </main>

        @include('cookieConsent::index')

        <script>

        var autocomplete = null;
        function initMap() {
            var input = document.getElementById('search-input');
    
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
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
        <script src="//js.pusher.com/3.1/pusher.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.min.js"></script>
        <script src="//unpkg.com/sweetalert2@7.20.8/dist/sweetalert2.all.js"></script>
        <script src="{{url('/js/notify.min.js')}}"></script>

        <!-- Scripts -->
        @yield('scripts')

        <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    if($(":focus").attr('id') == 'search-input'){
                        event.preventDefault();
                        return false;
                    } else {
                        return true;
                    }
                }
            });
        });
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123147608-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-123147608-1');
        </script>
    </body>
</html>
