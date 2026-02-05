<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Mail\Mailable;

class EnquiryReceived extends Mailable
{
    public function __construct(public Enquiry $enquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('New Guesthouse Enquiry')
            ->view('emails.enquiry-received');
    }
}
