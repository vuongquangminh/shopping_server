<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $recipientEmail;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string $recipientEmail
     * @param mixed $data
     */
    public function __construct($recipientEmail, $data)
    {
        $this->recipientEmail = $recipientEmail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipientEmail)->send(new MailNotify($this->data));

        return 'Email sent successfully!';
    }
}
