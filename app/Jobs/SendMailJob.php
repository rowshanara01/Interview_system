<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $to, public $massage, public $subject, public $body)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to)->send(new WelcomeEmail($this->massage, $this->subject, $this->body));
        Mail::to($this->to)->send(new WelcomeEmail($this->massage, $this->subject, $this->body));
    }
}
