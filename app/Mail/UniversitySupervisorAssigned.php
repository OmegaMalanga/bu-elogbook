<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UniversitySupervisorAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public User $supervisor;
    public User $student;

    /**
     * Create a new message instance.
     */
    public function __construct(User $supervisor, User $student)
    {
        $this->supervisor = $supervisor;
        $this->student = $student;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been assigned as a university supervisor - BU E-Logbook',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.university-supervisor-assigned',
        );
    }
}