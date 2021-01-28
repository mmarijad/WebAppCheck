<?php

namespace App\Jobs;

use App\Mail\SendBackgroundInvoice ;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subject;
    protected $content;
    protected $receiver = [];

    /**
     * Create a new job instance.
     *
     * @param $subject
     * @param $content
     * @param $receiver
     */
    public function __construct($subject, $content, $receiver)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->receiver = $receiver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendBackgroundNotificaton($this->subject, $this->content);
        Mail::to($this->receiver)->send($email);
    }
}