@extends('layouts.admin')

@section('title', 'Modifica stanze e prezzi del tuo immobile '.$house->name)

@section('content')
<div class="container margin-top-20">
    <h6 class="step-number">{{$house->name}}</h6>
    <h3 class="step-title">Modifica stanze e prezzi</h3>

    <hr>

    <div ng-app="RoomsEdit" ng-controller="MainCtrl">

        <div class="container" style="<% (bedsCount > 4) ? 'max-width: 90%;' : ''%>">
            <div class="row beds-row">
                <div class="text-center col" style="width: <% width*room.beds %>%; flex: 0 0 <% width*room.beds %>%; max-width: <% width*room.beds %>%;" ng-repeat="room in rooms">
                    <div class="row">

                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-repeat="user in room.accepted_users">
                            <img class="rounded-circle" ng-src="<% user.profile_pic %>">
                            <div class="actions margin-top-10">
                                <button class="btn btn-sm btn-success disabled"><% user.complete_name %></button>
                                <small class="mb-1 margin-top-10">Acceder&agrave; all'immobile tra </small>
                            </div>
                        </div>
                        
                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-repeat="i in getEmptyArrayBySize(room.beds - room.not_available_beds.length - room.accepted_users.length) track by $index">
                            <img class="rounded-circle" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU9AcAAJcAch8aQj4AAAAASUVORK5CYII=">
                            <div class="actions margin-top-10">
                                <button class="btn btn-elegant btn-sm" ng-click="removeBed(room.id)">Rimuovi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rooms-container row margin-top-10">
                <div class="col text-center" style="width: <% width*room.beds%>%; flex: 0 0 <% width*room.beds%>%; max-width: <% width*room.beds%>%;" ng-repeat="room in rooms">
                    <div class="room"></div>
                    <h6 class="text-uppercase margin-top-10">Stanza <% $index +1 %></h6>
                    <div class="actions">
                        <button class="btn btn-success btn-sm" ng-click="addBed(room.id)">Aggiungi un posto letto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
                {{-- PER OGNI STANZA STAMPO GLI UTENTI PRESENTI
                @foreach($room->acceptedUsers as $user)
                    <div class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                        <a href="{{$user->profile_url}}"><img class="rounded-circle" src="{{$user->profile_pic}}" alt="{{$user->first_name}} {{$user->last_name}}" data-toggle="tooltip" data-placement="bottom" title="Visualizza profilo"></a>
                        
                        @if($user->pivot->available_from)
                            <h6 class="free-place margin-top-10">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h6>
                        @else
                            <h6 class="user-name margin-top-10">{{$user->first_name}} {{$user->last_name}}</h6>
                        @endif

                        @if($user->pivot->start > \Carbon\Carbon::now()->format('Y-m-d'))
                            <small class="mb-1 margin-top-10">Acceder&agrave; all'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->start)->format('d/m/Y')}}</small>
                        @endif

                        @if($user->pivot->stop === null)
                            <button class="btn btn-elegant btn-sm remove-user" data-user="{{$user->id}}" data-name="{{$user->complete_name}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->start}}">Rimuovi</button>
                        @elseif($user->pivot->stop !== null && $user->pivot->available_from === null)
                            @if(\Carbon\Carbon::now()->format('Y-m-d') < $user->pivot->stop)
                                <small class="mb-1 margin-top-10">Abbandoner&agrave; l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</small>
                            @else
                                <small class="mb-1 margin-top-10">Ha abbandonato l'immobile il {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->stop)->format('d/m/Y')}}</small>
                            @endif
                            <button class="btn btn-success btn-sm selectAvailableDate" data-user="{{$user->id}}" data-room="{{$room->id}}" data-start-date="{{$user->pivot->stop}}">Imposta disponibilità</button>
                        @endif
                    </div>
                @endforeach

                {{-- PER OGNI STANZA STAMPO I POSTI VUOTI MA NON ANCORA DISPONIBILI 
                @foreach($room->notAvailableBeds as $user)
                    @if($user->pivot->stop < \Carbon\Carbon::now()->format('Y-m-d'))
                        <div class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                            <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile">
                            <h6 class="free-place margin-top-10">Disponibile dal {{\Carbon\Carbon::createFromFormat('Y-m-d',$user->pivot->available_from)->format('d/m/Y')}}</h6>
                        </div>
                    @endif
                @endforeach

                {{-- se ci sono posti liberi
                @if($room->beds - ($room->acceptedUsers->count() + $room->notAvailableBeds->count()))
                    @for($i = 0; $i < $room->beds - $room->acceptedUsers->count(); $i++)   
                        <div id="bed-{{$room->id}}-{{$i}}" class="text-center col-lg-4" style="width: {{100/$house->beds}}%; flex: 0 0 {{100/$house->beds}}%; max-width: {{100/$house->beds}}%;">
                        <img class="rounded-circle" src="{{url('/images/free-bed.png')}}" alt="{{$room->bed_price}}€">
                        <h6 class="free-place margin-top-10">{{$room->bed_price}}€</h6>
                        </div>
                    @endfor
                @endif
            @endforeach
            </div><!-- /.row -->
            
            <div class="rooms-container row margin-top-10">
            @foreach($house->rooms as $room)
            <div class="col-lg-4" style="width: {{(100/$house->beds)*$room->beds}}%; flex: 0 0 {{(100/$house->beds)*$room->beds}}%; max-width: {{(100/$house->beds)*$room->beds}}%;">
                <div class="room"></div>
                <h6 class="text-uppercase text-center margin-top-10">Stanza {{$loop->index +1}}</h6>
            </div>
            @endforeach
            </div><!-- /.row -->
        </div><!-- /.container -->



        <div class="row">
            <div class="col" ng-repeat="room in rooms" ng-cloak style="width: <% width * room.beds %>%">
                <% room.beds %>
            </div>
        </div>
    </div> --}}

</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
moment.locale('it');

var app = angular.module('RoomsEdit', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('MainCtrl', function($scope) {
    $scope.rooms = {!!json_encode($house->rooms()->with(['acceptedUsers', 'notAvailableBeds'])->get())!!};

    console.log($scope.rooms);

    $scope.bedsCount = 0;
    for(var i in $scope.rooms) {
        $scope.bedsCount += $scope.rooms[i].beds;
    }
    $scope.width = 100/$scope.bedsCount;

    $scope.getEmptyArrayBySize = function(num) {
        return new Array(num);
    }

    $scope.addBed = function(id) {
        for(var i in $scope.rooms) {
            if($scope.rooms[i].id == id) {
                $scope.rooms[i].beds++;
                $scope.bedsCount++;
                $scope.width = 100/$scope.bedsCount;
            }
        }
    }

    $scope.removeBed = function(id) {
        for(var i in $scope.rooms) {
            if($scope.rooms[i].id == id) {
                $scope.rooms[i].beds--;
                $scope.bedsCount--;
                $scope.width = 100/$scope.bedsCount;
            }
        }
    }
});
</script>
@endsection