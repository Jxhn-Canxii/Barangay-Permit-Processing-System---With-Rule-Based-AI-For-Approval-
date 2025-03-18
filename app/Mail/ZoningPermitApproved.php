<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoningPermitApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $permit;

    public function __construct($permit)
    {
        $this->permit = $permit;
    }

    public function build()
    {
        return $this->subject("Your Zoning Permit Has Been Approved")
                    ->view('emails.zoning_approved');
    }
}

