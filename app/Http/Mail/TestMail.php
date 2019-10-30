<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $record;
    public $title;
    public $urls;
    public $subtitle;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($record, $title,$urls,$subtitle)
    {
        $this->record = $record;
        $this->title = $title;
        $this->urls = $urls;
        $this->subtitle = $subtitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Email Travoy')->view('mail.index');

        return $mail;
    }
}
