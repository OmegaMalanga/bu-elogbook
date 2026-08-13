<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    protected $fillable = [
        'internship_id',
        'date',
        'operations_carried_out',
        'tools_equipment_used',
        'challenges_faced',
        'recommendations',
        'status',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function isReviewable(): bool
    {
        $fridayOfWeek = \Carbon\Carbon::parse($this->date)
            ->startOfWeek(\Carbon\Carbon::MONDAY)
            ->addDays(4)
            ->startOfDay();

        return now()->startOfDay()->gte($fridayOfWeek);
    }
}