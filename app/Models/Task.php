<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Project;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'project_id',
        'assigned_to'
    ];

    // Une tâche appartient à un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Utilisateur assigné à la tâche
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}