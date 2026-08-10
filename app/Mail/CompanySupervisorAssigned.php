<?php

namespace App\Mail;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanySupervisorAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public User $supervisor;
    public User $student;
    public Internship $internship;

    public function __construct(User $supervisor, User $student, Internship $internship)
    {
        $this->supervisor = $supervisor;
        $this->student = $student;
        $this->internship = $internship;
    }

    public function build()
    {
        return $this->subject('You have been assigned as a company supervisor - BU E-Logbook')
            ->view('emails.company-supervisor-assigned');
    }
}