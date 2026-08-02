@extends('layouts.app')

@section('title', 'Gestion des tâches')

@section('content')

<div class="container-fluid">

    <!-- Titre -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Gestion des tâches
            </h2>

            <p class="text-muted">
                Gérez toutes les tâches de vos projets.
            </p>

        </div>

        <div>

            <a href="/admin/tasks/create" class="btn btn-primary">
                Ajouter
            </a>

            <a href="/admin/tasks/export-pdf" class="btn btn-danger">
                PDF
            </a>

            <a href="/admin/tasks/export-excel" class="btn btn-success">
                Excel
            </a>

            <a href="/admin/tasks/kanban" class="btn btn-warning">
                Kanban
            </a>

        </div>

    </div>

    <!-- Recherche -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body">

            <form action="/admin/tasks" method="GET">

                <div class="row">

                    <div class="col-md-10">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Rechercher une tâche..."
                            value="{{ $search }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            Rechercher

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Statistiques -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body text-center">

                    <h2 class="text-primary">

                        {{ $tasks->total() }}

                    </h2>

                    <p class="text-muted mb-0">

                        Nombre total de tâches

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body text-center">

                    <h2 class="text-success">

                        {{ \App\Models\Task::where('status','Terminée')->count() }}

                    </h2>

                    <p class="text-muted mb-0">

                        Tâches terminées

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body text-center">

                    <h2 class="text-warning">

                        {{ \App\Models\Task::where('status','En cours')->count() }}

                    </h2>

                    <p class="text-muted mb-0">

                        Tâches en cours

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Tableau -->

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>

                            <th>Titre</th>

                            <th>Projet</th>

                            <th>Assigné à</th>

                            <th>Statut</th>

                            <th>Date limite</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($tasks as $task)
                    <tr>

    <td>
        <strong>#{{ $task->id }}</strong>
    </td>

    <td>
        {{ $task->title }}
    </td>

    <td>
        {{ $task->project->title ?? '-' }}
    </td>

    <td>
        {{ $task->assignedUser->name ?? '-' }}
    </td>

    <td>

        @if($task->status == 'Terminée')

            <span class="badge bg-success">
                Terminée
            </span>

        @elseif($task->status == 'En cours')

            <span class="badge bg-warning text-dark">
                En cours
            </span>

        @else

            <span class="badge bg-secondary">
                A faire
            </span>

        @endif

    </td>

    <td>

        {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

    </td>

    <td>

        <a href="/admin/tasks/edit/{{ $task->id }}"
           class="btn btn-sm btn-primary">

            Modifier

        </a>

        <a href="/admin/tasks/delete/{{ $task->id }}"
           class="btn btn-sm btn-danger"
           onclick="return confirm('Supprimer cette tâche ?')">

            Supprimer

        </a>

    </td>

</tr>
@empty

<tr>

    <td colspan="7" class="text-center py-4">

        <span class="text-muted">

            Aucune tâche trouvée.

        </span>

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<div class="d-flex justify-content-center mt-4">

    {{ $tasks->links() }}

</div>

</div>

@endsection