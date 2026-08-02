@extends('layouts.app')

@section('title', 'Modifier une tâche')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Modifier la tâche
        </h2>

        <p class="text-muted">
            Modifiez les informations de la tâche.
        </p>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <form method="POST" action="/admin/tasks/update/{{ $task->id }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Titre

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ $task->title }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Description

                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="form-control"
                        required>{{ $task->description }}</textarea>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Projet

                        </label>

                        <select
                            name="project_id"
                            class="form-select"
                            required>

                            @foreach($projects as $project)

                                <option
                                    value="{{ $project->id }}"
                                    {{ $task->project_id == $project->id ? 'selected' : '' }}>

                                    {{ $project->title }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Utilisateur assigné

                        </label>

                        <select
                            name="assigned_to"
                            class="form-select"
                            required>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    {{ $task->assigned_to == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Statut

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option
                                value="A faire"
                                {{ $task->status == 'A faire' ? 'selected' : '' }}>

                                A faire

                            </option>

                            <option
                                value="En cours"
                                {{ $task->status == 'En cours' ? 'selected' : '' }}>

                                En cours

                            </option>

                            <option
                                value="Terminée"
                                {{ $task->status == 'Terminée' ? 'selected' : '' }}>

                                Terminée

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Date limite

                        </label>

                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ $task->deadline }}">

                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle-fill"></i>

                        Mettre à jour

                    </button>

                    <a
                        href="/admin/tasks"
                        class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Retour

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection