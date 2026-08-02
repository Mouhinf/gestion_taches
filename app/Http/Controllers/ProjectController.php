<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $projects = Project::with('manager')

            ->when($search, function ($query) use ($search) {

                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');

            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view('admin.projects.index', compact(
            'projects',
            'search'
        ));
    }

    public function create()
    {
        $managers = User::where('role_id', 2)->get();

        return view('admin.projects.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|max:255',

            'description' => 'required',

            'manager_id' => 'required|exists:users,id'

        ]);

        $project = Project::create([

            'title' => $request->title,

            'description' => $request->description,

            'manager_id' => $request->manager_id

        ]);

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Création du projet : ' . $project->title

        ]);

        return redirect('/admin/projects')

            ->with('success', 'Projet ajouté avec succès.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $managers = User::where('role_id', 2)->get();

        return view('admin.projects.edit', compact(
            'project',
            'managers'
        ));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([

            'title' => 'required|max:255',

            'description' => 'required',

            'manager_id' => 'required|exists:users,id'

        ]);

        $project->update([

            'title' => $request->title,

            'description' => $request->description,

            'manager_id' => $request->manager_id

        ]);

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Modification du projet : ' . $project->title

        ]);

        return redirect('/admin/projects')

            ->with('success', 'Projet modifié avec succès.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Suppression du projet : ' . $project->title

        ]);

        $project->delete();

        return redirect('/admin/projects')

            ->with('success', 'Projet supprimé avec succès.');
    }
}