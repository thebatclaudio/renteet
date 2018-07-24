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
                        <a href="#" data-id="{{$conversation->id}}" class="conversation-item list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                                <div class="col-md-auto">
                                    <img src="{{$conversation->image_url}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{$conversation->name}}">
                                </div>
                                <div class="col">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h5 class="mb-1">{{$conversation->name}}</h5>
                                        @if($conversation->unreaded_count > 0)
                                            <span id="counter_{{$conversation->id}}" class="badge red badge-pill">{{$conversation->unreaded_count}}</span>
                                        @else
                                            <span id="counter_{{$conversation->id}}" class="badge red badge-pill" style="display:none;">{{$conversation->unreaded_count}}</span>
                                        @endif
                                    </div>
                                    <small id="lastMessage_{{$conversation->id}}" class="align-text-right">{{$conversation->last_message}}</small>
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
    var chatId = null;
    var chatContent = document.getElementById('chatContent');
    $(".conversation-item").click(function(){
        chatId = $(this).data("id");
        var url = "{{route('ajax.chat.messages',['id'=>':id'])}}";
        $.get(url.replace(':id',chatId),{page:0},function(result){
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
            
            //pulisco il counter message nel dropdown del profilo
            var counter = parseInt($("#counterMessages").text()) - parseInt($("#counter_"+chatId).text());
            $("#counterMessages").text(counter);
            if(counter == 0) $("#counterMessages").fadeOut();

            //pulisco il badge counter nel container delle conversations
            $("#counter_"+chatId).fadeOut();
            $("#counter_"+chatId).text(0);
            
        });
    })

    $('#btn-chat').click(function(){
        var url = "{{route('ajax.chat.sendMessage',['id'=>':id'])}}";
        var message = $('#messageTextArea').val();
        if(message !== "" && message !== null && chatId !== null){
            $.post(url.replace(':id',chatId),{message:message},function(result){
                if(result.status == 'OK'){
                    var html = '<div class="row margin-top-10">';
                    html+='<div class="col"><p class="text-right"><small>{{\Auth::user()->complete_name}}</small><br>'+message+'</p></div>';
                    html+='<div class="col-auto"><img src="{{\Auth::user()->profile_pic}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{\Auth::user()->complete_name}}"></div>';
                    html+='</div>';
                    $("#chatContent").append(html);
                    chatContent.scrollTop = chatContent.scrollHeight;
                    $('#messageTextArea').val("").focus();
                    $('#lastMessage_'+chatId).text(message);
                }else{
                    swal("Si è verificato un errore", "Riprova più tardi", "error");
                }
            });
        }
    });

    channel.bind('App\\Events\\MessageReceived', function(data) {
       if(data.messageObj.conversation_id == chatId){
            var html = "";
            html += '<div class="row margin-top-10">';
            html+='<div class="col-auto"><img src="'+data.fromUser.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+data.fromUser.complete_name+'"></div>';
            html+='<div class="col"><p class="text-left"><small>'+data.fromUser.complete_name+'</small><br>'+data.message+'</p></div>';
            html+='</div>';
            $("#chatContent").append(html);
            chatContent.scrollTop = chatContent.scrollHeight;
       }else{
            var count = $("#counter_"+data.messageObj.conversation_id).text();
            $("#counter_"+data.messageObj.conversation_id).text(parseInt(count) + 1);
            $("#counter_"+data.messageObj.conversation_id).fadeIn();
       }
       $('#lastMessage_'+data.messageObj.conversation_id).text(data.message);
    });
});


</script>

@endsection