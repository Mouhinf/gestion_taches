<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Role;
use App\Models\Task;
use App\Models\Project;
use App\Models\ActivityLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relation avec Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relation avec Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relation avec Project
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Relation avec ActivityLog
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}