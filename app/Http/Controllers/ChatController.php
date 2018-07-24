<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\ConversationUser;
use App\Message;
use App\House;
use App\User;
use \App\Events\MessageReceived;

class ChatController extends Controller
{
    public function showChat(){
        return view('chat',[
            'conversations'=>\Auth::user()->conversations
        ]);
    }

    public function getMessages($id,Request $request){
        if($conversation = Conversation::find($id)){
            $messages = Message::where('conversation_id',$id); 
            if($conversation->house_id != null){
                $messages = $messages->where('to_user_id',\Auth::user()->id);
            }
            $messages->update(['unreaded'=>false]);
            return response()->json($messages->with('fromUser')->orderBy('created_at','desc')->skip(($request->page-1)*10)->take(10)->get()->sortBy('created_at')->values()->all());
        }

        return response()->json([
            'status' => 'KO'
        ]);
    }

    public function sendMessage($id,Request $request){
        if($conversation = Conversation::find($id)){
            if($conversation->house_id == null){
                $toUser = $conversation->users()->where('user_id','!=',\Auth::user()->id)->first()->id;
                $message = Message::create([
                    'from_user_id'=>\Auth::user()->id,
                    'to_user_id'=>$toUser,
                    'conversation_id'=>$id,
                    'message'=>$request->message
                ]);
                // lancio l'evento per inviare la notifica push
                event(new MessageReceived($toUser, $message->id,\Auth::user()->id));
                //User::find($id)->notify(new \App\Notifications\MessageReceived($id, $message->id,\Auth::user()->id));
                return response()->json([
                    'status' => 'OK'
                ]);
            }else{
                if(in_array($conversation->house_id,\Auth::user()->relatedHouses()->pluck('id')->toArray())){
                    foreach($conversation->house->relatedUsers() as $user){
                        if($user != \Auth::user()->id){
                            $message = Message::create([
                                'from_user_id'=>\Auth::user()->id,
                                'to_user_id'=>$user,
                                'conversation_id'=>$id,
                                'message'=>$request->message
                            ]);
                            // lancio l'evento per inviare la notifica push
                            event(new MessageReceived($user, $message->id,\Auth::user()->id));
                            //User::find($id)->notify(new \App\Notifications\MessageReceived($id, $message->id,\Auth::user()->id));
                        }else{
                            Message::create([
                                'from_user_id'=>\Auth::user()->id,
                                'to_user_id'=>$user,
                                'conversation_id'=>$id,
                                'message'=>$request->message,
                                'unreaded' => false
                            ]);
                        }
                    }
                    return response()->json([
                        'status' => 'OK'
                    ]);
                }
            }
        }
        return response()->json([
            'status' => 'KO'
        ]);
    }

    public function newChat($id,Request $request){
        $userConversation = ConversationUser::where('user_id',\Auth::user()->id)->pluck('conversation_id')->toArray();
        $conversationUserId = ConversationUser::where('user_id',$id)->whereIn('conversation_id',$userConversation)->pluck('conversation_id')->toArray();
        $conversation = Conversation::whereNull('house_id')->whereIn('id',$conversationUserId);

        if($conversation->count()){
           return $this->sendMessage($conversation->first()->id,$request);
        }else{
            $newConversation = new \App\Conversation;
            $newConversation->house_id = null;
            $newConversation->save();
            ConversationUser::create([
                'conversation_id'=>$newConversation->id,
                'user_id' => $id
            ]);
            ConversationUser::create([
                'conversation_id'=>$newConversation->id,
                'user_id' => \Auth::user()->id
            ]);
            return $this->sendMessage($newConversation->id,$request);
        }
    }
}
