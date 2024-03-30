<?php

namespace App\Jobs;

use App\Models\User;
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
        Log::error("Job", [$payload]);
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
        $user = User::first();
        $user->name = uniqid();
        $user->save();

        Log::error("Job sent at ", [$this->message]);
    }
}
