<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Renteet') }} - @yield('title')</title>
    
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">        <link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

        <link rel="stylesheet" href="/css/app.css?{{rand()}}">
        <link rel="stylesheet" href="/css/utilities.css?{{rand()}}">
        <link rel="stylesheet" href="/css/icons.css?{{rand()}}">

        @yield('styles')
    </head>
    <body>

        <header>
            <nav class="main-navbar navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{url('/')}}" title="{{ config('app.name', 'Renteet') }} - Home">
                    <img class="logo" src="/images/renteet-logo.png">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <form id="searchForm" class="form-inline mt-2 mt-md-0 d-none d-sm-inline-flex" action="{{route('search.coordinates')}}" method="GET">
                    <input id="lat" name="lat" type="hidden" required>
                    <input id="lng" name="lng" type="hidden" required>
                    <input id="search-input" name="searchInput" class="col-md-7 form-control" type="text" onFocus="geolocate()" placeholder="Prova &quot;Palermo&quot;" aria-label="Cerca">
                    <i class="search-icon fa fa-search fa-2x" aria-hidden="true"></i>
                </form>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto d-block d-sm-none">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="#">Come funziona?</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrati</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
                    @else
                        <li class="nav-item profile-nav-item">
                            <div class="row">
                                <div class="col-auto">
                                    <img src="{{ Auth::user()->profile_pic }}" class="profile-pic pull-left">
                                </div>
                                <div class="col">
                                    <h5>{{ Auth::user()->complete_name }}</h5>
                                    <a href="{{ route('user.profile', \Auth::user()->id) }}">Visualizza il tuo profilo</a>
                                </div>
                                <div class="col-auto align-self-end">
                                    <div class="align-vertical-center">
                                        @if(\Auth::user()->unreadNotifications()->count())
                                        <a href="{{route('notifications')}}" id="btn-notifications" class="btn btn-xs btn-notifications dropdown-toggle unread" title="Notifiche">
                                            {{\Auth::user()->unreadNotifications()->count()}}
                                        </a>
                                        @else
                                        <a href="{{route('notifications')}}"  id="btn-notifications" class="btn btn-xs btn-notifications dropdown-toggle" title="Notifiche">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>

                        @if(\Auth::user()->isLessor())
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}">Gestisci le tue case</a>
                        </li>
                        @endif

                        @if(\Auth::user()->isTenant())
                        <li class="nav-item">
                            <a href="{{ route('myHouse') }}">La tua casa</a>
                        </li>
                        @endif

                        @if(\Auth::user()->pendingRequests()->count() >= 1)
                        <li class="nav-item">
                            <a href="{{ route('pendingRequests') }}">Le tue richieste in sospeso</a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Esci da Renteet</a>
                        </li>

                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.house.wizard.one')}}" class="btn btn-success btn-block">
                                Inserisci un annuncio
                            </a>
                        </li>  
                        <li class="nav-item margin-bottom-10">
                            <a href="#" class="btn btn-elegant btn-block">
                                Come funziona?
                            </a>
                        </li>                      
                    @endguest
                    </ul>
                </div>

                <ul class="navbar-nav mr-auto d-none d-sm-flex flex-row-reverse">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="#">Come funziona?</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrati</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
                    @else
                        <li class="nav-item dropdown">

                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{ Auth::user()->profile_pic }}" class="profile-pic">
                            </a>

                            <div class="user-menu dropdown-menu dropdown-menu-right" role="menu">
                                @if(\Auth::user()->isLessor())
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Gestisci le tue case</a>
                                @endif

                                @if(\Auth::user()->isTenant())
                                <a class="dropdown-item" href="{{ route('myHouse') }}">La tua casa</a>
                                @endif

                                                        @if(\Auth::user()->pendingRequests()->count() >= 1)
                            <a href="{{ route('pendingRequests') }}">Le tue richieste in sospeso</a>
                        @endif
                                <a class="dropdown-item" href="{{route('chat.show')}}">I tuoi messaggi
                                @if(\Auth::user()->allUnreadedCount() > 0)
                                    <span id="counterMessages" class="float-right badge red badge-pill">{{\Auth::user()->allUnreadedCount()}}</span>
                                @else
                                    <span id="counterMessages" class="float-right badge red badge-pill" style="display:none;">{{\Auth::user()->allUnreadedCount()}}</span>
                                @endif

                                </a>

                                <a class="dropdown-item" href="{{ route('user.profile', \Auth::user()->id) }}">Visualizza il tuo profilo</a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Esci da Renteet</a>
                                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                        <li class="nav-item">
                            @if(\Auth::user()->unreadNotifications()->count())
                            <button type="button" id="btn-notifications" class="btn btn-xs btn-notifications dropdown-toggle unread" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{\Auth::user()->unreadNotifications()->count()}}
                            </button>
                            @else
                            <button type="button" id="btn-notifications" class="btn btn-xs btn-notifications dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                            </button>
                            @endif

                            <div class="notifications-menu dropdown-menu dropdown-menu-right" role="menu">
                                <h6 class="dropdown-header text-center text-uppercase">Notifiche</h6>
                                <div id="notifications-menu-content">
                                    <a class="dropdown-item disabled text-center">Nessuna notifica</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center text-uppercase all-notifications-link" href="{{route('notifications')}}">Visualizza tutte le notifiche</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Come funziona?
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.house.wizard.one')}}" class="btn btn-success btn-sm">
                                Inserisci un annuncio
                            </a>
                        </li>                        
                    @endguest
                </ul>
            </nav>
        </header>
        
        <main role="main">
            @yield('content')

            @include('partials.footer')
        </main>

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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                });
            });
        
        });
        </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
    
        @if(\Auth::check())
        @include('partials.notifications');
        @endif
    </body>
</html>