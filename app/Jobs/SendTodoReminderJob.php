<?php

namespace App\Jobs;

use App\Models\Todo;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTodoReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function handle(EmailService $emailService)
    {
        $emailService->sendReminderEmail($this->todo);
    }
}