<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable;
    use SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->url = url('/aktivasi/'.$user->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('kamusku@kamusku.com')
                ->markdown('mail.userRegistered')
                ->with([
                    'url'  => $this->url,
                    'user' => $this->user->name,
                ]);
    }
}
