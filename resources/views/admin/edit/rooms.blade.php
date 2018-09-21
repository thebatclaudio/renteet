@extends('layouts.admin')

@section('title', 'Modifica stanze e prezzi del tuo immobile '.$house->name)

@section('content')
<div class="container margin-top-20" ng-app="RoomsEdit" ng-controller="MainCtrl">

    <div class="row">
        <div class="col">
            <h6 class="step-number">{{$house->name}}</h6>
            <h3 class="step-title">Modifica stanze e prezzi</h3>
        </div>

        <div class="col col-auto">
            <button ng-click="addRoom()" class="btn btn-outline-elegant"><i class="fas fa-plus"></i> Aggiungi una camera</button>
        </div>
    </div>

    <hr>

    <div>

        <div class="container" style="<% (bedsCount > 4) ? 'max-width: 90%;' : ''%>">
            <div class="row beds-row">
                <div class="text-center col" style="width: <% width*room.beds %>%; flex: 0 0 <% width*room.beds %>%; max-width: <% width*room.beds %>%;" ng-repeat="room in rooms" ng-if="!room.deleted">
                    <div class="row">

                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-repeat="user in room.accepted_users">
                            <img class="rounded-circle" ng-src="<% user.profile_pic %>">
                        </div>
                
                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-repeat="user in room.not_available_beds">
                            <img class="rounded-circle" src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU/A8AAUcBIofjvNQAAAAASUVORK5CYII=" alt="Posto non disponibile">
                        </div>
                        
                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-repeat="i in getEmptyArrayBySize(room.beds - room.not_available_beds.length - room.accepted_users.length) track by $index">
                            <img class="rounded-circle" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU9AcAAJcAch8aQj4AAAAASUVORK5CYII=">
                        </div>

                        <div class="text-center col" style="width: <% 100/room.beds %>%; flex: 0 0 <% 100/room.beds %>%; max-width: <% 100/room.beds %>%;" ng-if="!room.beds">
                            <img class="rounded-circle" style="opacity: 0.5" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNU9AcAAJcAch8aQj4AAAAASUVORK5CYII=">
                            <div class="actions margin-top-10">
                                <p class="small margin-top-20 text-uppercase">Nessun posto letto</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rooms-container row margin-top-10">
                <div class="col text-center" style="width: <% width*room.beds%>%; flex: 0 0 <% width*room.beds%>%; max-width: <% width*room.beds%>%;" ng-repeat="room in rooms track by $index" ng-if="!room.deleted">
                    <div class="room"></div>
                    <h5 class="text-uppercase margin-top-10">Camera</h5>
                    <div class="actions margin-top-20">
                        <div class="row flex justify-content-center">
                            <div class="col-auto">
                                <label>Posti letto</label>
                                <div class="input-group">
                                    <div class="button-minus input-group-prepend">
                                        <div class="input-group-text" ng-click="removeBed(room.id)"><i class="fas fa-minus"></i></div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="input-group-text beds-input"><% room.beds %></div>
                                    </div>
                                    <div class="button-plus input-group-append">
                                        <div class="input-group-text" ng-click="addBed(room.id)"><i class="fas fa-plus"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="actions margin-top-20">
                        <div class="row flex justify-content-center">
                            <div class="col-sm-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input type="number" class="form-control py-0 bed-price" ng-model="room.bed_price" data-trigger="focus" data-toggle="tooltip" title="Prezzo per posto letto">
                                    <div class="input-group-append">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-elegant" ng-if="!(room.not_available_beds+room.accepted_users)" ng-click="removeRoom(room.id)">Rimuovi camera</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row margin-top-40">
            <div class="col text-right">
                <hr />
                <a href="{{route('admin.dashboard')}}" class="btn btn-grey">Torna indietro</a>
                <button ng-click="save(rooms)" class="btn btn-success">Salva</button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
<script>
window.save = false;

var app = angular.module('RoomsEdit', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('MainCtrl', function($scope, $http) {
    var newCount = 0;
    $scope.rooms = {!!json_encode($house->rooms()->with(['acceptedUsers', 'notAvailableBeds'])->get())!!};

    $scope.bedsCount = countBeds($scope.rooms);
    $scope.width = 100/parseInt($scope.bedsCount);

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
                if($scope.rooms[i].beds > $scope.rooms[i].not_available_beds.length + $scope.rooms[i].accepted_users.length && $scope.rooms[i].beds > 1) {
                    $scope.rooms[i].beds--;
                    if($scope.rooms[i].beds!=0) {
                        $scope.bedsCount--;
                    }
                    $scope.width = 100/$scope.bedsCount;
                }
            }
        }
    }

    $scope.removeRoom = function(id) {
        for(var i in $scope.rooms) {
            if($scope.rooms[i].id == id) {
                swal({
                    title: "Sei sicuro di voler rimuovere questa stanza?",
                    icon: "warning",
                    buttons: ['Annulla', {
                        text: "Rimuovi"
                    }]
                }).then((send) => {
                    if(send){
                        $scope.$apply(function () {
                            $scope.rooms[i].deleted = true;
                            $scope.bedsCount-=$scope.rooms[i].beds;
                            $scope.rooms[i].beds = 0;
                            $scope.width = 100/$scope.bedsCount;
                        });
                    }
                });
                break;
            }
        }
    }

    $scope.addRoom = function(){
        newCount++;
        $scope.rooms.push({
            id: 'new-'+newCount,
            beds: 1,
            not_available_beds: [],
            accepted_users: [],
            bed_price: 100
        });

        $scope.bedsCount++;
        $scope.width = 100/$scope.bedsCount;
    }

    $scope.fromNow = function(date) {
        moment.locale('it');
        return moment(date, 'YYYY-MM-DD').fromNow()
    }

    $scope.save = function(rooms) {
        $http.post('{{route('admin.house.edit.rooms.save', $house->id)}}', {rooms: rooms}, ).then(function successCallback(response) {
            if(response.data.status == 'OK') {
                swal('Informazioni salvate correttamente', '', 'success').then(function(){
                    window.save = true;
                    window.location.href = "{{route('admin.dashboard')}}";
                });
            } else {
                swal('Si è verificato un errore', '', 'error')
            }
        }, function errorCallback(response) {
            swal('Si è verificato un errore', '', 'error')
        });
    }
});

function countBeds(rooms) {
    bedsCount = 0;
    for(var i in rooms) {
        if(rooms[i].beds != 0) {
            bedsCount += rooms[i].beds;
        } else {
            bedsCount++;
        }
    }
    return bedsCount;
}

window.onbeforeunload = function(){
    if(!window.save)
        return 'Sei sicuro di voler abbandonare la pagina?';
};


$("body").on('focus', '.bed-price', function(){
    console.log('tooltip');
    $(this).tooltip('show')
});
</script>
@endsection