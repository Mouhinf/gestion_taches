@extends('layouts.app')

@section('title', 'Modifier un projet')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Modifier le projet
        </h2>

        <p class="text-muted">
            Modifiez les informations du projet.
        </p>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <form method="POST" action="/admin/projects/update/{{ $project->id }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Titre du projet

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ $project->title }}"
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
                        required>{{ $project->description }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Manager responsable

                    </label>

                    <select
                        name="manager_id"
                        class="form-select"
                        required>

                        @foreach($managers as $manager)

                            <option value="{{ $manager->id }}"
                                {{ $project->manager_id == $manager->id ? 'selected' : '' }}>

                                {{ $manager->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle-fill"></i>

                        Mettre à jour

                    </button>

                    <a
                        href="/admin/projects"
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