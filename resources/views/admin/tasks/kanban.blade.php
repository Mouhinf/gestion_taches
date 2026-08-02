@extends('layouts.app')

@section('title', 'Vue Kanban')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Vue Kanban</h2>
            <p class="text-muted mb-0">
                Suivi des tâches par statut
            </p>
        </div>

        <a href="/admin/tasks" class="btn btn-secondary rounded-3">
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>

    </div>

    <div class="row">

        <!-- A faire -->

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-header bg-secondary text-white text-center fw-bold">

                    A faire

                    <span class="badge bg-light text-dark ms-2">
                        {{ count($todoTasks) }}
                    </span>

                </div>

                <div class="card-body bg-light">

                    @forelse($todoTasks as $task)

                    <div class="card mb-3 shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h5 class="fw-bold">
                                {{ $task->title }}
                            </h5>

                            <p class="text-muted small">
                                {{ $task->description }}
                            </p>

                            <hr>

                            <small>

                                <strong>Projet :</strong>

                                {{ $task->project->title ?? '-' }}

                            </small>

                            <br>

                            <small>

                                <strong>Assignée à :</strong>

                                {{ $task->assignedUser->name ?? '-' }}

                            </small>

                            <br>

                            <small class="text-danger">

                                <strong>Date limite :</strong>

                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            </small>

                        </div>

                    </div>

                    @empty

                    <div class="alert alert-light text-center">

                        Aucune tâche

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- En cours -->

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-header bg-warning text-dark text-center fw-bold">

                    En cours

                    <span class="badge bg-dark ms-2">

                        {{ count($inProgressTasks) }}

                    </span>

                </div>

                <div class="card-body bg-light">

                    @forelse($inProgressTasks as $task)

                    <div class="card mb-3 shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h5 class="fw-bold">

                                {{ $task->title }}

                            </h5>

                            <p class="text-muted small">

                                {{ $task->description }}

                            </p>

                            <hr>

                            <small>

                                <strong>Projet :</strong>

                                {{ $task->project->title ?? '-' }}

                            </small>

                            <br>

                            <small>

                                <strong>Assignée à :</strong>

                                {{ $task->assignedUser->name ?? '-' }}

                            </small>

                            <br>

                            <small class="text-danger">

                                <strong>Date limite :</strong>

                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            </small>

                        </div>

                    </div>

                    @empty

                    <div class="alert alert-light text-center">

                        Aucune tâche

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- Terminée -->

        <div class="col-lg-4">

            <div class="card border-0 shadow rounded-4">

                <div class="card-header bg-success text-white text-center fw-bold">

                    Terminée

                    <span class="badge bg-light text-dark ms-2">

                        {{ count($completedTasks) }}

                    </span>

                </div>

                <div class="card-body bg-light">

                    @forelse($completedTasks as $task)

                    <div class="card mb-3 shadow-sm border-0 rounded-4">

                        <div class="card-body">

                            <h5 class="fw-bold">

                                {{ $task->title }}

                            </h5>

                            <p class="text-muted small">

                                {{ $task->description }}

                            </p>

                            <hr>

                            <small>

                                <strong>Projet :</strong>

                                {{ $task->project->title ?? '-' }}

                            </small>

                            <br>

                            <small>

                                <strong>Assignée à :</strong>

                                {{ $task->assignedUser->name ?? '-' }}

                            </small>

                            <br>

                            <small class="text-danger">

                                <strong>Date limite :</strong>

                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            </small>

                        </div>

                    </div>

                    @empty

                    <div class="alert alert-light text-center">

                        Aucune tâche

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection