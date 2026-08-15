<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyDiagram extends Model
{
    protected $fillable = [
        'internship_id',
        'week_start_date',
        'file_path',
        'original_filename',
        'uploaded_at',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'uploaded_at' => 'datetime',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public static function currentWeekStart(): \Carbon\Carbon
    {
        return now()->startOfWeek(\Carbon\Carbon::MONDAY)->startOfDay();
    }
}