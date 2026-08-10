<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
   protected $fillable = [
        'student_id',
        'company_name',
        'company_supervisor_id',
        'university_supervisor_id',
        'department_id',
        'start_date',
        'end_date',
        'year_of_study',
        'pending_company_supervisor_name',
        'pending_university_supervisor_name',
        'pending_company_supervisor_email',
        'company_supervisor_invite_token',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function companySupervisor()
    {
        return $this->belongsTo(User::class, 'company_supervisor_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function universitySupervisor()
    {
        return $this->belongsTo(User::class, 'university_supervisor_id');
    }

    public function logEntries()
    {
        return $this->hasMany(LogEntry::class);
    }
}