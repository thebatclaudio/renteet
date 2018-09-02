<!-- MOBILE NAV -->
<div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto d-block d-sm-none">

    @guest
        <!-- OSPITI -->
        <li class="nav-item"><a class="nav-link" href="{{url('come-funziona')}}" title="Come funziona?">Come funziona?</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrati</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Accedi</a></li>
    @else
        <!-- LOGGATI -->
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

        <li class="nav-item">
            <a href="{{route('chat.show')}}">
                I tuoi messaggi
                @if(\Auth::user()->allUnreadedCount() > 0)
                    <span id="counterMessages" class="float-right badge badge-danger badge-pill">{{\Auth::user()->allUnreadedCount()}}</span>
                @else
                    <span id="counterMessages" class="float-right badge badge-danger badge-pill" style="display:none;">{{\Auth::user()->allUnreadedCount()}}</span>
                @endif
            </a>
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
        @if(\Auth::user()->signup_complete == true)
            <li class="nav-item">
                <a href="{{route('admin.house.wizard.one')}}" class="btn btn-success btn-block">
                    Inserisci un annuncio
                </a>
            </li>
        @endif  
        <li class="nav-item margin-bottom-10">
            <a href="{{url('come-funziona')}}" title="Come funziona?"class="btn btn-elegant btn-block">
                Come funziona?
            </a>
        </li>                      
    @endguest
    </ul>
</div>
<!-- END MOBILE NAV -->