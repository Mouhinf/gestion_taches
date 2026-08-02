@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Nouvelle tâche
        </h2>

        <p class="text-muted">
            Créez une nouvelle tâche et assignez-la à un utilisateur.
        </p>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <form method="POST" action="/admin/tasks/store">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Titre

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Titre de la tâche"
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
                        placeholder="Description de la tâche"></textarea>

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

                            <option value="">
                                Sélectionner un projet
                            </option>

                            @foreach($projects as $project)

                                <option value="{{ $project->id }}">

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

                            <option value="">
                                Sélectionner un utilisateur
                            </option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">

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

                            <option value="A faire">
                                A faire
                            </option>

                            <option value="En cours">
                                En cours
                            </option>

                            <option value="Terminée">
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
                            class="form-control">

                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle-fill"></i>

                        Enregistrer

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