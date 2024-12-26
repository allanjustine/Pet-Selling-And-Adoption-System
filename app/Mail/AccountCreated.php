<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public $user,
        public $password
    )
    {
        //
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), 'Furfect')
                    ->subject('Furfect - Account Created')
                    ->markdown('emails.account_created', [
                        'user' => $this->user,
                        'password' => $this->password,

        ]); // with params
    }
}