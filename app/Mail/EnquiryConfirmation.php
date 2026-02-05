<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Mail\Mailable;

class EnquiryConfirmation extends Mailable
{
    public function __construct(public Enquiry $enquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('We Received Your Enquiry')
            ->view('emails.enquiry-confirmation');
    }
}
