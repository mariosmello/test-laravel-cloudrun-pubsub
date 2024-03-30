<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EchoOutput implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $message;

    /**
     * Create a new job instance.
     */
    public function __construct($payload)
    {
        Log::critical("Job", [$payload]);
        $this->message = [
            'name'=>'test',
            'date'=>$payload
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::critical("Job sent at ", [$this->message]);
    }
}
