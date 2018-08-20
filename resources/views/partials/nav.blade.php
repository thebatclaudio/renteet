<!-- DESKTOP NAV -->
<ul class="navbar-nav mr-auto d-none d-sm-flex flex-row-reverse">
    @guest
        <!-- OSPITI -->
        <li class="nav-item"><a class="nav-link" href="{{url('come-funziona')}}" title="Come funziona?">Come funziona?</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrati</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
    @else
        <!-- LOGGATI -->
        
        <!-- DROPDOWN MENU UTENTE -->
        <li class="nav-item dropdown">

            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <img src="{{ Auth::user()->profile_pic }}" class="profile-pic" style="display:inline;">
                @if(\Auth::user()->allUnreadedCount() > 0)
                    <span id="badge-messages" class="badge badge-danger rounded-circle">{{\Auth::user()->allUnreadedCount()}}</span>
                @else
                <span id="badge-messages" class="badge badge-danger rounded-circle"></span>                                
                @endif
            </a>

            <div class="user-menu dropdown-menu dropdown-menu-right" role="menu">
                @if(\Auth::user()->isLessor())
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Area del locatore</a>
                @endif

                @if(\Auth::user()->isTenant())
                    <a class="dropdown-item" href="{{ route('myHouse') }}">La tua casa</a>
                @endif

                @if(\Auth::user()->pendingRequests()->count() >= 1)
                    <a class="dropdown-item" href="{{ route('pendingRequests') }}">Le tue richieste in sospeso</a>
                @endif
                
                <a class="dropdown-item" href="{{route('chat.show')}}">
                    I tuoi messaggi
                    @if(\Auth::user()->allUnreadedCount() > 0)
                        <span id="counterMessages" class="float-right badge badge-danger badge-pill">{{\Auth::user()->allUnreadedCount()}}</span>
                    @else
                        <span id="counterMessages" class="float-right badge badge-danger badge-pill" style="display:none;">{{\Auth::user()->allUnreadedCount()}}</span>
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
        <!-- FINE DROPDOWN UTENTE -->

        <!-- DROPDOWN NOTIFICHE -->
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
        <!-- FINE DROPDOWN NOTIFICHE -->


        <li class="nav-item text-link">
            <a href="{{url('come-funziona')}}" title="Come funziona?" class="nav-link">
                Aiuto
            </a>
        </li>

        @if(\Auth::user()->isLessor())
            <li class="nav-item text-link"><a class="nav-link" href="{{ route('admin.dashboard') }}">Area del locatore</a></li>
        @endif

        <li class="nav-item text-link">
            <a class="nav-link" href="{{route('chat.show')}}">
                Messaggi
                @if(\Auth::user()->allUnreadedCount() > 0)
                    <span id="newMessageBadge" class="new-message-badge"></span>
                @else
                    <span id="newMessageBadge" class="new-message-badge" style="display: none"></span>
                @endif
            </a>
        </li>

        @if(\Auth::user()->isTenant())
            <li class="nav-item text-link"><a class="nav-link" href="{{ route('myHouse') }}">La tua casa</a></li>
        @endif

        @if(\Auth::user()->signup_complete == true)
            <li class="nav-item">
                <a href="{{route('admin.house.wizard.one')}}" class="btn btn-success btn-sm">
                    Inserisci un annuncio
                </a>
            </li>
        @endif                        
    @endguest
</ul>
<!-- END DESKTOP NAV -->