<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'email',
        'due_date',
        'completed',
        'reminder_sent',
        'reminder_sent_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'completed' => 'boolean',
        'reminder_sent' => 'boolean',
    ];

    public function emailLogs(): MorphMany
    {
        return $this->morphMany(EmailLog::class, 'emailable');
    }

    public function scopePendingReminders($query)
    {
        return $query->where('completed', false)
                    ->where('reminder_sent', false)
                    ->where('due_date', '<=', now()->addMinutes(10));
    }
};
