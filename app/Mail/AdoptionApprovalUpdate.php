<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionApprovalUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $adoption)
    {
        //
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), 'app.furfect@gmail.com')
                    ->subject('Furfect - Pet Adoption Approval Update')
                    ->markdown('emails.adoption_approval_update', [
                        'adoption' => $this->adoption,
                        'url' => route('seller.adoptions.show', $this->adoption),

        ]); // with params
    }
}