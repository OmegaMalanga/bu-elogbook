<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'internship_id',
        'technical_competence',
        'punctuality_attendance',
        'initiative_problem_solving',
        'professionalism_work_ethic',
        'communication_teamwork',
        'company_supervisor_submitted_at',
        'final_grade',
        'university_supervisor_submitted_at',
    ];

    protected $casts = [
        'company_supervisor_submitted_at' => 'datetime',
        'university_supervisor_submitted_at' => 'datetime',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function criteriaTotal(): ?int
    {
        if (is_null($this->technical_competence)) {
            return null;
        }

        return $this->technical_competence
            + $this->punctuality_attendance
            + $this->initiative_problem_solving
            + $this->professionalism_work_ethic
            + $this->communication_teamwork;
    }
}