<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\House;
use App\Review;

class ReviewReceived extends Notification
{
    use Queueable;

    public $user;
    public $from_user;
    public $review;
    public $house;

    /**
     * Create a new notification instance.
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
            $this->house = null;
            if($review->lessor == true){
                if($house = House::find($house_id)){
                    $this->house = $house;
                }
            }
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {   
        if($this->review->lessor == true){
            return [
                'user_id' => $this->from_user->id,
                'review_id' => $this->review->id,
                'house_id' => $this->house->id
            ];
        }else{
            return [
                'user_id' => $this->from_user->id,
                'review_id' => $this->review->id
            ]; 
        }
    }
}
