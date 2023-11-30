<?php

namespace App\Mail\DiagnosticTest;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResultToParent extends Mailable
{
    use Queueable, SerializesModels;

    public $reports;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $reports)
    {
        $this->reports = $reports;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mathematics Diagnostic Test Report')->markdown('emails.diagnostic_test.result_to_parent');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
