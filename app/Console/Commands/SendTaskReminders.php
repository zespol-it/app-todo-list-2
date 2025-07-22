<?php

namespace App\Console\Commands;

use App\Jobs\SendTaskReminder;
use App\Models\Task;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wysyła powiadomienia e-mail o zadaniach na jutro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        
        $tasks = Task::whereDate('due_date', $tomorrow)
            ->where('status', '!=', 'done')
            ->with('user')
            ->get();

        $count = 0;
        
        foreach ($tasks as $task) {
            SendTaskReminder::dispatch($task);
            $count++;
        }

        $this->info("Wysłano {$count} powiadomień o zadaniach na jutro.");
    }
}
