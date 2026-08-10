<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'log_entry_id',
        'reviewer_id',
        'comment',
        'status',
    ];

    public function logEntry()
    {
        return $this->belongsTo(LogEntry::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}