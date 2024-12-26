<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $user, public $request)
    {
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('app.name')),
            subject: 'Furfect - Account Update',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.account_update',
            with: [
                'url' => route('auth.login'),
                'request' => $this->request,
            ]
        );
    }
   
    // public function build()
    // {
    //     return $this->from(config('mail.from.address'), 'Furfect')
    //                 ->subject('Furfect - Account Status Update')
    //                 ->markdown('emails.account_update', [
    //                     'user' => $this->user,
    //                     'url' => route('auth.login'),

    //     ]); // with params
    // }
}