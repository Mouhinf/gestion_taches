@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Gestion des utilisateurs
            </h2>

            <p class="text-muted mb-0">
                Liste de tous les utilisateurs de la plateforme
            </p>

        </div>

        <a href="/admin/users/create" class="btn btn-primary rounded-3">

            <i class="bi bi-person-plus-fill"></i>

            Ajouter un utilisateur

        </a>

    </div>

    <!-- Barre de recherche -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <form method="GET" action="/admin/users">

                <div class="row">

                    <div class="col-md-10">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Rechercher un utilisateur..."
                            value="{{ request('search') }}">

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

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Nom</th>

                        <th>Email</th>

                        <th>Rôle</th>

                        <th class="text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            <strong>#{{ $user->id }}</strong>
                        </td>

                        <td>
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role_id == 1)

                                <span class="badge bg-danger">
                                    Administrateur
                                </span>

                            @elseif($user->role_id == 2)

                                <span class="badge bg-warning text-dark">
                                    Manager
                                </span>

                            @else

                                <span class="badge bg-success">
                                    Utilisateur
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            @if($user->role_id != 1)

                                <a href="/admin/users/edit/{{ $user->id }}"
                                   class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <a href="/admin/users/delete/{{ $user->id }}"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer cet utilisateur ?')">

                                    <i class="bi bi-trash"></i>

                                </a>

                            @else

                                <span class="badge bg-secondary">
                                    Protégé
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center text-muted">

                            Aucun utilisateur trouvé.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        <a href="/admin/dashboard" class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Retour au Dashboard

        </a>

    </div>

</div>

@endsection