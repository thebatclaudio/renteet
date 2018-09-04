<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\House;

class ExitFromHouse extends Notification
{
    use Queueable;

    public $user;
    public $house;
    public $owner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $house_id)
    {
        $user = User::find($user_id);
        $house = House::find($house_id);
        if($user && $house) {
            $this->user = $user;
            $this->owner = $house->owner;
            $this->house = $house;
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
        return ['database', 'mail'];
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
            ->subject($this->user->complete_name.' ha abbandonato il tuo immobile')
            ->view(
                'emails.exitFromHouse', [
                    'user' => $this->user,
                    'house' => $this->house
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'house_id' => $this->house->id,
            'owner_id' => $this->owner->id
        ];
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->owner->email;
    }
}
