@extends('layouts.app')

@section('title', 'Gestion des projets')

@section('content')

<div class="container-fluid">

    <!-- Titre -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Gestion des projets</h2>
            <p class="text-muted mb-0">
                Liste de tous les projets enregistrés
            </p>
        </div>

        <a href="/admin/projects/create" class="btn btn-primary rounded-3">
            <i class="bi bi-folder-plus"></i>
            Ajouter un projet
        </a>

    </div>

    <!-- Statistiques -->
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h2 class="fw-bold text-primary">
                                {{ $projects->total() }}
                            </h2>

                            <p class="text-muted mb-0">
                                Nombre de projets
                            </p>

                        </div>

                        <i class="bi bi-folder-fill text-primary"
                           style="font-size:50px;"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Recherche -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body">

            <form method="GET" action="/admin/projects">

                <div class="row">

                    <div class="col-md-10">

                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Rechercher un projet..."
                            value="{{ $search }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>

                            Rechercher

                        </button>

                    </div>

                </div>

            </form>

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

                            <th>Projet</th>

                            <th>Description</th>

                            <th>Manager</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($projects as $project)

                        <tr>

                            <td>
                                <strong>#{{ $project->id }}</strong>
                            </td>

                            <td>

                                <strong>

                                    {{ $project->title }}

                                </strong>

                            </td>

                            <td>

                                {{ \Illuminate\Support\Str::limit($project->description,70) }}

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    {{ $project->manager->name ?? 'Non assigné' }}

                                </span>

                            </td>

                            <td class="text-center">

                                <a href="/admin/projects/edit/{{ $project->id }}"
                                   class="btn btn-outline-primary btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <a href="/admin/projects/delete/{{ $project->id }}"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Supprimer ce projet ?')">

                                    <i class="bi bi-trash"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center py-4 text-muted">

                                Aucun projet trouvé.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center mt-4">

                {{ $projects->links() }}

            </div>

        </div>

    </div>

    <div class="mt-4">

        <a href="/admin/dashboard"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Retour au Dashboard

        </a>

    </div>

</div>

@endsection