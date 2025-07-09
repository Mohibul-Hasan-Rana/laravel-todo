<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailLog extends Model
{
    protected $fillable = [
        'to_email',
        'subject',
        'body',
        'status',
        'attachments',
        'type',
        'sent_at',
        'error_message'
    ];

    protected $casts = [
        'attachments' => 'array',
        'sent_at' => 'datetime',
    ];

    public function emailable(): MorphTo
    {
        return $this->morphTo();
    }
}