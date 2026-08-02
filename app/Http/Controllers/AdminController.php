<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Statistiques
        $usersCount = User::count();

        $managersCount = User::where('role_id', 2)->count();

        $projectsCount = Project::count();

        $tasksCount = Task::count();

        $pendingTasks = Task::where('status', 'A faire')->count();

        $inProgressTasks = Task::where('status', 'En cours')->count();

        $completedTasks = Task::where('status', 'Terminée')->count();

        // Tâches en retard
        $lateTasks = Task::whereDate('deadline', '<', Carbon::today())
            ->where('status', '!=', 'Terminée')
            ->count();

        $lateTasksList = Task::with('project')
            ->whereDate('deadline', '<', Carbon::today())
            ->where('status', '!=', 'Terminée')
            ->get();

        // Dernières tâches
        $recentTasks = Task::with([
            'project',
            'assignedUser'
        ])
        ->latest()
        ->take(8)
        ->get();

        // Evénements du calendrier
        $calendarEvents = Task::all()->map(function ($task) {

            if ($task->status == 'Terminée') {
                $color = '#198754';
            } elseif ($task->status == 'En cours') {
                $color = '#ffc107';
            } else {
                $color = '#dc3545';
            }

            return [
                'title' => $task->title,
                'start' => $task->deadline,
                'color' => $color,
            ];
        });

        return view('admin.dashboard', compact(
            'usersCount',
            'managersCount',
            'projectsCount',
            'tasksCount',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'lateTasks',
            'lateTasksList',
            'recentTasks',
            'calendarEvents'
        ));
    }
}