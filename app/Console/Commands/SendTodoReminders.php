<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Jobs\SendTodoReminderJob;
use Illuminate\Console\Command;

class SendTodoReminders extends Command
{
    protected $signature = 'todo:send-reminders';
    protected $description = 'Send reminder emails for todos due in 10 minutes';

    public function handle()
    {
        $todos = Todo::pendingReminders()->get();
        
        foreach ($todos as $todo) {
            SendTodoReminderJob::dispatch($todo);
        }
        
        $this->info("Dispatched {$todos->count()} reminder emails");
    }
}