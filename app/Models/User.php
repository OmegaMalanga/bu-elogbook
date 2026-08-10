<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Department;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function internship()
{
    return $this->hasOne(Internship::class, 'student_id');
}

public function companySupervisorFor()
{
    return $this->hasMany(Internship::class, 'company_supervisor_id');
}

public function universitySupervisorFor()
{
    return $this->hasMany(Internship::class, 'university_supervisor_id');
}

public function reviewsGiven()
{
    return $this->hasMany(Review::class, 'reviewer_id');
}
public function department()
{
    return $this->belongsTo(Department::class);
}
}
