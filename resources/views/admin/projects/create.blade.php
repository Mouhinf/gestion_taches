@extends('layouts.app')

@section('title', 'Ajouter un projet')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Nouveau projet
        </h2>

        <p class="text-muted">
            Créez un nouveau projet et assignez-le à un manager.
        </p>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <form method="POST" action="/admin/projects/store">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Titre du projet

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Ex : Développement Application Web"
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
                        placeholder="Décrivez le projet..."
                        required></textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Manager responsable

                    </label>

                    <select
                        name="manager_id"
                        class="form-select"
                        required>

                        <option value="">

                            Sélectionner un manager

                        </option>

                        @foreach($managers as $manager)

                            <option value="{{ $manager->id }}">

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

                        Enregistrer

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