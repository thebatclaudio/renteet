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
use App\House;

class ExitFromHouse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $house;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $house_id)
    {
        $user = User::find($user_id);
        $house = House::find($house_id);
        if($user && $house) {
            $this->user = $user;
            $this->house = $house;
            $this->message  = "{$this->user->name} ha abbandonato il tuo immobile. Seleziona la data in cui tornerà disponibile";
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['user.'.$this->house->owner->id];
    }
}
