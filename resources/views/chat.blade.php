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
                        @forelse($conversations as $conversation)
                            <a href="#" data-id="{{$conversation->id}}" class="conversation-item list-group-item list-group-item-action flex-column align-items-start {{($loop->first) ? 'active' : ''}}">
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
                        @empty
                            <h5 class="text-center text-muted margin-top-20">Nessuna conversazione</h5>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-md-8">
            <div class="card">
                <div id="chatContent" class="card-body" style="height:400px; overflow-y:scroll;">
                    @foreach($messages as $message)
                        <div class="row margin-top-10">
                        @if($message->from_user_id == \Auth::user()->id)
                            <div class="col"><p class="text-right"><small>{{$message->fromUser->complete_name}}</small><br>{!!$message->html_message!!}</p></div>
                            <div class="col-auto">
                                <a class="no-style" href="{{$message->fromUser->profile_url}}" title="{{$message->fromUser->first_name}} {{$message->fromUser->last_name}}">
                                    <img src="{{$message->fromUser->profile_pic}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{$message->fromUser->complete_name}}">
                                </a>
                            </div>
                        @else
                            <div class="col-auto">
                                <a class="no-style" href="{{$message->fromUser->profile_url}}" title="{{$message->fromUser->first_name}} {{$message->fromUser->last_name}}">
                                    <img src="{{$message->fromUser->profile_pic}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{$message->fromUser->complete_name}}">
                                </a>
                            </div>
                            <div class="col"><p class="text-left"><small>{{$message->fromUser->complete_name}}</small><br>{!!$message->html_message!!}</p></div>
                        @endif
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form id="form-chat">
                        <div class="input-group">
                            <textarea id="messageTextArea" style="resize:none;" class="form-control input-md" rows="1" placeholder="Inserisci il tuo messaggio..."></textarea>
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm" type="submit" id="btn-chat">Invia</button>
                            </span>
                        </div>
                    </form>
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

    function sendChat(){
        var url = "{{route('ajax.chat.sendMessage',['id'=>':id'])}}";
        var message = $('#messageTextArea').val();
        if(message !== "" && message !== null && chatId !== null){
            $.post(url.replace(':id',chatId),{message:message},function(result){
                if(result.status == 'OK'){
                    var html = '<div class="row margin-top-10">';
                    html+='<div class="col"><p class="text-right"><small>{{\Auth::user()->complete_name}}</small><br>'+message+'</p></div>';
                    html+='<div class="col-auto"><a class="no-style" href="{{\Auth::user()->profile_url}}" title="{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}">';
                    html+='<img src="{{\Auth::user()->profile_pic}}" class="img-fluid rounded-circle" style="max-width:60px;" alt="{{\Auth::user()->complete_name}}"></a></div>';
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
    }

    @if($conversations->isNotEmpty())
        chatId = {{$conversations->first()->id}};
    @endif

    var chatContent = document.getElementById('chatContent');
    chatContent.scrollTop = chatContent.scrollHeight;

    $(".conversation-item").click(function(){
        $(".conversation-item.active").removeClass("active");
        $(this).addClass("active");
        chatId = $(this).data("id");
        var url = "{{route('ajax.chat.messages',['id'=>':id'])}}";
        $.get(url.replace(':id',chatId),{page:0},function(result){
            var html = "";
            for (var i in result){
                html += '<div class="row margin-top-10">';
                if(result[i].from_user_id == userId){
                    html+='<div class="col"><p class="text-right"><small>'+result[i].from_user.complete_name+'</small><br>'+result[i].html_message+'</p></div>';
                    html+='<div class="col-auto"><a class="no-style" href="'+result[i].from_user.profile_url+'" title="'+result[i].from_user.complete_name+'">';
                    html+='<img src="'+result[i].from_user.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+result[i].from_user.complete_name+'"></a></div>';
                }else{
                    html+='<div class="col-auto"><a class="no-style" href="'+result[i].from_user.profile_url+'" title="'+result[i].from_user.complete_name+'">';
                    html+='<img src="'+result[i].from_user.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+result[i].from_user.complete_name+'"></a></div>';
                    html+='<div class="col"><p class="text-left"><small>'+result[i].from_user.complete_name+'</small><br>'+result[i].html_message+'</p></div>';
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
            $('#chatContent').scrollTop($('#chatContent')[0].scrollHeight);
        });
    })

    $('#btn-chat').click(sendChat());
    $('#form-chat').submit(function(event){
        event.preventDefault();
        sendChat();
    });
    $("#messageTextArea").keypress(function (e) {
        if(e.which == 13) {
            if(!e.shiftKey) {
                e.preventDefault();
                sendChat();
            }
        }
    });

    channel.bind('App\\Events\\MessageReceived', function(data) {
       if(data.messageObj.conversation_id == chatId){
            var html = "";
            html += '<div class="row margin-top-10">';
            html+='<div class="col-auto"><a class="no-style" href="'+data.fromUser.profile_url+'" title="'+data.fromUser.complete_name+'">';
            html+='<img src="'+data.fromUser.profile_pic+'" class="img-fluid rounded-circle" style="max-width:60px;" alt="'+data.fromUser.complete_name+'"></a></div>';
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
    
    $('#chatContent').scrollTop($('#chatContent')[0].scrollHeight);

});


</script>

@endsection