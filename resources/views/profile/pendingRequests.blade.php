@extends('layouts.app')

@section('title', "Richieste di adesione in sospeso")

@section('styles')
<link rel="stylesheet" type="text/css" href="{{url('/css/profile.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="page-target-container margin-target-container">
            <h3 class="page-target">Richieste di adesione in sospeso</h3>
        </div>
    </div>

    <div class="margin-top-120">
        @foreach($requests as $request)
            <a href="{{$request->house->url}}" title="{{'Visualizza la casa'}}" class="notification-link">
                <div class="card shadow margin-top-40 col-sm-8">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <img class="profile-pic img-fluid" src="{{$request->house->preview_image_url}}" width="80" height="80">
                            </div>
                            <div class="col">
                                <h5 class="margin-top-10">{{$request->house->name}}</h5>
                                <small class="notification-date">Inizio soggiorno: <strong>{{\Carbon\Carbon::createFromFormat('Y-m-d', $request->pivot->start)->format('d/m/Y')}}</strong></small>
                                <small class="notification-date">Inviata <strong class="date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->pivot->created_at)->timestamp}}000</strong></small>
                            </div>
                        </div>
                        <div class="row margin-top-10 text-right">
                            <div class="col">
                                <a class="btn btn-elegant btn-cancel btn-sm" data-room="{{$request->id}}">Annulla richiesta</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    moment.locale('it');
    $(".date").each(function() {
        $(this).text(moment.utc($(this).text(), 'x').fromNow());
    });
});

$(".btn-cancel").on("click", function () {
    var button = $(this);

    var url = '{{route('cancel.request', [ 'room' => ':room'])}}';

    swal({
        title: "Sei sicuro di voler annullare la richiesta di adesione?",
        text: "",
        buttons: [true, {
            text: 'Annulla richiesta',
            closeModal: false
          }]
    })
    .then((send) => {
        if (!send) throw null;
        $.post(url.replace(':room', button.data("room")), function( data ) {
            if(data.status === 'OK') {
                swal("Richiesta di adesione annullata!", "", "success").then(() => { location.reload() });;;
                button.attr('disabled', true);
            }else {
              swal("Si è verificato un errore", "Riprova più tardi", "error");
            }
        });    
    })
    .catch(err => {
          if (err) {
              swal("Si è verificato un errore", "Riprova più tardi", "error");  
          } else {
            swal.stopLoading();
            swal.close();
          }
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
@endsection