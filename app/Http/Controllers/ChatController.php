<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\House;
use App\User;

class ChatController extends Controller
{
    public function showChat(){
        $conversations = \Auth::user()->conversations();
        $conversationsToReturn = [];
        foreach($conversations as $conversation){
            $message = Message::find($conversation->id);
            $conversation->lastMessage = (strlen($message->message)>80) ? substr($message->message,0,80)."..." : $message->message;
            if($conversation->type === 'house'){
                $conversation->image = House::find($message->to_house_id)->preview_image_url;
                $conversation->chatId = $message->to_house_id;
            }else{
                $conversation->image = User::find($message->from_user_id)->profile_pic;
                $conversation->chatId = $message->from_user_id;
            }
            $conversationsToReturn[] = $conversation;
        }
        return view('chat',[
            'conversations'=>$conversationsToReturn
        ]);
    }

    public function getMessages($type, $id,Request $request){
        if($type == 'house'){
            $messages = Message::where('to_house_id',$id);
        }else{
            $messages = Message::where(function($query) use($id){
                return $query->where('from_user_id',$id)->where('to_user_id',\Auth::user()->id);
            })->orWhere(function($query) use($id){
                return $query->where('from_user_id',\Auth::user()->id)->where('to_user_id',$id);
            });
        }
        return response()->json($messages->with('fromUser')->orderBy('created_at','desc')->skip(($request->page-1)*10)->take(10)->get()->sortBy('created_at')->values()->all());
    }

    public function sendMessage($type, $id,Request $request){
        if($type == 'user'){
            Message::create([
                'from_user_id'=>\Auth::user()->id,
                'to_user_id'=>$id,
                'to_house_id'=>null,
                'message'=>$request->message
            ]);
        }else{
            if(in_array($id,\Auth::user()->relatedHouses()->pluck('id')->toArray())){
                Message::create([
                    'from_user_id'=>\Auth::user()->id,
                    'to_user_id'=>null,
                    'to_house_id'=>$id,
                    'message'=>$request->message
                ]);
            }else{
                return response()->json([
                    'status' => 'KO'
                ]);
            }     
        }

        return response()->json([
            'status' => 'OK'
        ]);

    }
}
