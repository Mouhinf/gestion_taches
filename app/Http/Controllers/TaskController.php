<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $tasks = Task::with(['project', 'assignedUser'])
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.tasks.index', compact('tasks', 'search'));
    }

    public function create()
    {
        // Seul l'administrateur peut créer une tâche
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        $projects = Project::all();
        $users = User::whereIn('role_id', [2, 3])->get();

        return view('admin.tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        // Validation sécurisée
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:A faire,En cours,Terminée',
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        try {

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'deadline' => $request->deadline,
                'project_id' => $request->project_id,
                'assigned_to' => $request->assigned_to,
            ]);

            return redirect('/admin/tasks')
                ->with('success', 'Tâche créée avec succès.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la tâche.');
        }
    }

    public function edit($id)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::whereIn('role_id', [2, 3])->get();

        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:A faire,En cours,Terminée',
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        try {

            $task = Task::findOrFail($id);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'deadline' => $request->deadline,
                'project_id' => $request->project_id,
                'assigned_to' => $request->assigned_to,
            ]);

            return redirect('/admin/tasks')
                ->with('success', 'Tâche modifiée avec succès.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification.');
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        Task::findOrFail($id)->delete();

        return redirect('/admin/tasks')
            ->with('success', 'Tâche supprimée avec succès.');
    }

    // Mise à jour du statut (manager)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:A faire,En cours,Terminée',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Statut mis à jour.');
    }

    // Tableau Kanban
    public function kanban()
    {
        $tasks = Task::all()->groupBy('status');

        $todoTasks = $tasks['A faire'] ?? collect();
        $inProgressTasks = $tasks['En cours'] ?? collect();
        $completedTasks = $tasks['Terminée'] ?? collect();

        return view('admin.tasks.kanban', compact(
            'todoTasks',
            'inProgressTasks',
            'completedTasks'
        ));
    }

    // Export PDF
    public function exportPdf()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        $tasks = Task::with(['project', 'assignedUser'])->get();

        $pdf = Pdf::loadView('admin.tasks.pdf', compact('tasks'));

        return $pdf->download('liste_taches.pdf');
    }

    // Export Excel
    public function exportExcel()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Accès refusé');
        }

        $tasks = Task::with(['project', 'assignedUser'])->get();

        Excel::create('liste_taches', function ($excel) use ($tasks) {

            $excel->sheet('Taches', function ($sheet) use ($tasks) {

                $sheet->row(1, [
                    'ID',
                    'Titre',
                    'Projet',
                    'Assigné à',
                    'Statut',
                    'Date limite'
                ]);

                foreach ($tasks as $index => $task) {

                    $sheet->row($index + 2, [
                        $task->id,
                        $task->title,
                        $task->project->title ?? '',
                        $task->assignedUser->name ?? '',
                        $task->status,
                        $task->deadline
                    ]);
                }
            });

        })->download('xlsx');
    }
}