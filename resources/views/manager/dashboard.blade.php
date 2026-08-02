@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Tableau de bord Manager
            </h2>

            <p class="text-muted">
                Gérez vos projets et le suivi des tâches.
            </p>

        </div>

    </div>

    @foreach($projects as $project)

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-header bg-primary text-white rounded-top-4">

            <h4 class="mb-0">

                <i class="bi bi-folder-fill me-2"></i>

                {{ $project->title }}

            </h4>

        </div>

        <div class="card-body">

            <p class="text-muted">

                {{ $project->description }}

            </p>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Tâche</th>

                            <th>Utilisateur</th>

                            <th>Statut</th>

                            <th>Date limite</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($project->tasks as $task)

                        <tr>

                            <td>

                                <strong>{{ $task->title }}</strong>

                            </td>

                            <td>

                                {{ $task->assignedUser->name ?? '-' }}

                            </td>

                            <td>

                                <form method="POST"
                                      action="/manager/tasks/update-status/{{ $task->id }}">

                                    @csrf

                                    <select
                                        class="form-select"
                                        name="status"
                                        onchange="this.form.submit()">

                                        <option value="A faire"
                                            {{ $task->status=='A faire' ? 'selected' : '' }}>
                                            A faire
                                        </option>

                                        <option value="En cours"
                                            {{ $task->status=='En cours' ? 'selected' : '' }}>
                                            En cours
                                        </option>

                                        <option value="Terminée"
                                            {{ $task->status=='Terminée' ? 'selected' : '' }}>
                                            Terminée
                                        </option>

                                    </select>

                                </form>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center text-muted">

                                Aucune tâche pour ce projet.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @endforeach

</div>

@endsection