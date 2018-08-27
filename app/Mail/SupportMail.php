<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Support;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Support $support)
    {
        $this->user = $user;
        $this->support = $support;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@renteet.com')
                ->view('emails.supportMail')
                ->with([
                    'user' => $this->user,
                    'support' => $this->support
                ]);      
    }
}
