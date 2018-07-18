@extends('layouts.app')

@section('title', 'La tua casa')

@section('styles')

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="page-target-container margin-top-40">
            <h3 class="page-target">I tuoi messaggi</h3>
        </div>
    </div>
    <div class="row margin-top-120">
        <div class="col-md-4">
            <div class="card">
                <div style="height:400px; overflow-y:scroll">
                    <div class="list-group">
                    @foreach($conversations as $conversation)
                        <a href="#" data-id="{{$conversation->chatId}}" data-type="{{$conversation->type}}" class="conversation-item list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                                <div class="col-md-auto">
                                    <img src="{{$conversation->image}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{$conversation->name}}">
                                </div>
                                <div class="col">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h5 class="mb-1">{{$conversation->name}}</h5>
                                        <span class="badge red badge-pill">{{$conversation->unreaded}}</span>
                                    </div>
                                    <small class="align-text-right">{{$conversation->lastMessage}}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div id="chatContent" class="card-body" style="height:400px; overflow-y:scroll;">
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <textarea id="messageTextArea" style="resize:none;" class="form-control input-md" rows="1" placeholder="Inserisci il tuo messaggio..."></textarea>
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm" id="btn-chat">Invia</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>
@endsection

@section('scripts')
<script>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function(){
    var userId = {{\Auth::user()->id}};
    var type = null;
    var chatId = null;
    var chatContent = document.getElementById('chatContent');
    $(".conversation-item").click(function(){
        type = $(this).data("type");
        chatId = $(this).data("id");
        var url = "{{route('ajax.chat.messages',['type'=>':type','id'=>':id'])}}";
        $.get(url.replace(':type',type).replace(':id',chatId),{page:0},function(result){
            var html = "";
            for (var i in result){
                html += '<div class="row margin-top-10">';
                if(result[i].from_user_id == userId){
                    html+='<div class="col"><p class="text-right"><small>'+result[i].from_user.complete_name+'</small><br>'+result[i].message+'</p></div>';
                    html+='<div class="col-auto"><img src="'+result[i].from_user.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+result[i].from_user.complete_name+'"></div>';
                }else{
                    html+='<div class="col-auto"><img src="'+result[i].from_user.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+result[i].from_user.complete_name+'"></div>';
                    html+='<div class="col"><p class="text-left"><small>'+result[i].from_user.complete_name+'</small><br>'+result[i].message+'</p></div>';
                }
                html+='</div>';   
            }
            $("#chatContent").html(html);
            chatContent.scrollTop = chatContent.scrollHeight;
        });
    })

    $('#btn-chat').click(function(){
        var url = "{{route('ajax.chat.sendMessage',['type'=>':type','id'=>':id'])}}";
        var message = $('#messageTextArea').val();
        if(message !== "" && message !== null && type !== null && chatId !== null){
            $.post(url.replace(':type',type).replace(':id',chatId),{message:message},function(result){
                if(result.status == 'OK'){
                    var html = '<div class="row margin-top-10">';
                    html+='<div class="col"><p class="text-right"><small>{{\Auth::user()->complete_name}}</small><br>'+message+'</p></div>';
                    html+='<div class="col-auto"><img src="{{\Auth::user()->profile_pic}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{\Auth::user()->complete_name}}"></div>';
                    html+='</div>';
                    $("#chatContent").append(html);
                    chatContent.scrollTop = chatContent.scrollHeight;
                    $('#messageTextArea').val("").focus();
                }else{
                    swal("Si è verificato un errore", "Riprova più tardi", "error");
                }
            });
        }
    });
});


</script>

@endsection