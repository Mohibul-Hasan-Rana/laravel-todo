<?php

namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TodoReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $todo;
    public $csvPath;

    public function __construct(Todo $todo, $csvPath)
    {
        $this->todo = $todo;
        $this->csvPath = $csvPath;
    }

    public function build()
    {
        return $this->view('emails.todo-reminder')
                    ->subject('Todo Reminder: ' . $this->todo->title)
                    ->attach(Storage::path($this->csvPath), [
                        'as' => 'posts.csv',
                        'mime' => 'text/csv',
                    ]);
    }
}