<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PetApprovalUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $pet)
    {
        //
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), 'app.furfect@gmail.com')
                    ->subject('Furfect - Pet Approval Update')
                    ->markdown('emails.pet_approval_update', [
                        'pet' => $this->pet,
                        'url' => route('seller.pets.show', $this->pet),

        ]); // with params
    }
}