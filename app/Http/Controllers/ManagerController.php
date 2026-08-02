<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ManagerController extends Controller
{
    public function index()
    {
        $projects = Project::where('manager_id', Auth::id())
                    ->with('tasks')
                    ->get();

        return view('manager.dashboard', compact('projects'));
    }
}