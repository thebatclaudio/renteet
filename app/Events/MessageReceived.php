<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use App\Message;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $user;
    public $fromUser;
    public $messageObj;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id,$message_id,$from_user_id)
    {
        $user = User::find($user_id);
        $from_user = User::find($from_user_id);
        $messageObj = Message::find($message_id);
        if($user && $messageObj && $from_user){
            $this->user = $user;
            $this->fromUser = $from_user; 
            $this->messageObj = $messageObj;
            $this->message  = $messageObj->message;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['user.'.$this->user->id];
    }
}
