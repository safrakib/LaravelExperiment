<?php

namespace App\Jobs;

use App\Senders\psl;
use Illuminate\Bus\Queueable;
use App\Mail\UserRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SmsSender implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $messages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messages)
    {
        $this->messages=$messages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //psl::sendMessage($this->messages);
        Mail::to('rakib8315@gmail.com')->send(new UserRegistration());
    }
}
