@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">House</div>

        <div class="panel-body">
            <h3>{{$house->name}}</h3>
            <hr>
            <h4>Stanze</h4>
            <div class="rooms-list row">
                @foreach($house->rooms as $index => $room)
                <div class="col-md-4">
                    <div class="card room-el">
                        <img class="card-img-top" src="{{$house->preview_image_url}}" alt="{{$index+1}}">
                        <div class="card-block">
                            <h4 class="card-title">Stanza {{$index+1}}</h4>
                            <h5><i class="fa fa-bed"></i> x {{$room->beds}}</h5>
                            <hr>
                            <h5>Inquilini</h5>
                            <div class="list-group">
                                @forelse($room->acceptedUsers as $user)
                                <div class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$user->first_name}} {{$user->last_name}}</h5>
                                        <small>3 minuti fa</small>
                                    </div>
                                    <!--p class="mb-1">Ipotetico messaggio</p-->
                                    @if(!$user->pivot->accepted_by_owner)
                                    <button class="btn btn-default btn-xs">Visualizza profilo</button>
                                    <button class="btn btn-primary btn-xs accept-user" data-user="{{$user->id}}" data-room="{{$room->id}}">Accetta</button>
                                    @endif
                                </div>
                                @empty
                                <h6 class="text-center text-muted">Nessun inquilino</h6>
                                @endforelse
                            </div>
                            <hr>
                            <h5>Utenti interessati</h5>
                            <div class="list-group">
                                @forelse($room->pendingUsers as $user)
                                <div class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$user->first_name}} {{$user->last_name}}</h5>
                                        <small>3 minuti fa</small>
                                    </div>
                                    <!--p class="mb-1">Ipotetico messaggio</p-->
                                    @if(!$user->pivot->accepted_by_owner)
                                    <button class="btn btn-default btn-xs">Visualizza profilo</button>
                                    <button class="btn btn-primary btn-xs accept-user" data-user="{{$user->id}}" data-room="{{$room->id}}">Accetta</button>
                                    @endif
                                </div>
                                @empty
                                <h6 class="text-center text-muted">Nessun utente interessato</h6>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
    });

    $(".accept-user").on("click", function () {
        var button = $(this);

        var url = '{{route('allow.user', [ 'room' => ':room', 'user' => ':user'])}}';

        $.post(url.replace(':room', button.data("room")).replace(':user', button.data("user")), function( data ) {
            if(data.status === 'OK') {
                button.fadeOut();
            }
        });
    });

</script>
@endsection