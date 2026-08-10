<?php

namespace App\Mail;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanySupervisorInvite extends Mailable
{
    use Queueable, SerializesModels;

    public User $student;
    public Internship $internship;
    public string $token;

    public function __construct(User $student, Internship $internship, string $token)
    {
        $this->student = $student;
        $this->internship = $internship;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('You have been invited as a company supervisor - BU E-Logbook')
            ->view('emails.company-supervisor-invite');
    }
}