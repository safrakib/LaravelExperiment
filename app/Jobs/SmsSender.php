<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Senders\psl;

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
        psl::sendMessage($this->messages);
    }
}
