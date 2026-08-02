<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class UserController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())
                    ->with('project')
                    ->get();

        return view('user.dashboard', compact('tasks'));
    }
}