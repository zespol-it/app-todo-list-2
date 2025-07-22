<?php

namespace App\Jobs;

use App\Mail\TaskReminder;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Task $task
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->task->user->email)
            ->send(new TaskReminder($this->task));
    }
}
