<?php

namespace App\Services;

use App\Models\EmailLog;
use App\Models\Todo;
use App\Mail\TodoReminderMail;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailService
{
    protected $apiController;

    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
    }

    public function sendReminderEmail(Todo $todo)
    {
        try {
            // Fetch posts from API
            $posts = $this->apiController->fetchPosts();
            
            // Generate CSV
            $csvPath = $this->generateCsv($posts);
            
            // Send email
            Mail::to($todo->email)->send(new TodoReminderMail($todo, $csvPath));
            
            // Log successful email
            $this->logEmail($todo, 'reminder', 'sent', null, [$csvPath]);
            
            // Update todo
            $todo->update([
                'reminder_sent' => true,
                'reminder_sent_at' => now()
            ]);
            
            // Clean up CSV file
            Storage::delete($csvPath);
            
        } catch (\Exception $e) {
            $this->logEmail($todo, 'reminder', 'failed', $e->getMessage());
            throw $e;
        }
    }

    public function sendCompletionNotification(Todo $todo)
    {
        try {
            // Implementation for completion notification
            
            $this->logEmail($todo, 'completion', 'sent');
            
        } catch (\Exception $e) {
            $this->logEmail($todo, 'completion', 'failed', $e->getMessage());
        }
    }

    protected function generateCsv($posts)
    {
        $csvData = "ID,Title\n";
        
        foreach ($posts as $post) {
            $csvData .= sprintf(
            "%d,\"%s\"\n",
            $post['id'],
            str_replace('"', '""', $post['title'])
            );
        }
        
        $filename = 'posts_' . now()->format('Y_m_d_H_i_s') . '.csv';
        Storage::put($filename, $csvData);
        
        return $filename;
    }

    protected function logEmail(Todo $todo, $type, $status, $errorMessage = null, $attachments = null)
    {
        EmailLog::create([
            'emailable_type' => Todo::class,
            'emailable_id' => $todo->id,
            'to_email' => $todo->email,
            'subject' => $this->getEmailSubject($type, $todo),
            'body' => $this->getEmailBody($type, $todo),
            'status' => $status,
            'type' => $type,
            'attachments' => $attachments,
            'sent_at' => $status === 'sent' ? now() : null,
            'error_message' => $errorMessage
        ]);
    }

    protected function getEmailSubject($type, $todo)
    {
        return match($type) {
            'reminder' => "Reminder: {$todo->title}",
            'completion' => "Completed: {$todo->title}",
            default => "Todo Notification"
        };
    }

    protected function getEmailBody($type, $todo)
    {
        return match($type) {
            'reminder' => "This is a reminder for your todo: {$todo->title}",
            'completion' => "Your todo has been completed: {$todo->title}",
            default => "Todo notification"
        };
    }
}