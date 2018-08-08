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
use App\Review;

class ReviewReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $from_user;
    public $review;
    public $house;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    
    public function __construct($user_id,$review_id,$from_user_id,$house_id)
    {
        $user = User::find($user_id);
        $from_user = User::find($from_user_id);
        $review = Review::find($review_id);
        if($user && $review && $from_user){
            $this->user = $user;
            $this->from_user = $from_user; 
            $this->review = $review;
            $this->message  = $review->rate;
            $this->house = null;
            if($review->lessor == true){
                if($house = House::find($house_id)){
                    $this->house = $house;
                }
            }

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
