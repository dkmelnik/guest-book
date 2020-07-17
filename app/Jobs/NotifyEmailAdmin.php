<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyEmailAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messageEmail;
    public $address;
    /**
     * Create a new job instance.
     * @param string $messageEmail
     * @param string $address
     * @return void
     */
    public function __construct($messageEmail, $address)
    {
        $this->messageEmail = $messageEmail;
        $this->address = $address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $address = $this->address;
        $messageEmail = $this->messageEmail;

        \Mail::raw($messageEmail, function ($message) use ($address, $messageEmail)
        {
            $message->from('ml.dmitriymelnik@yandex.ru', 'ml');
            $message->to($address);
        });
    }
}
