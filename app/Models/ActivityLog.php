<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'user_id'
    ];

    // Un journal d'activité appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}