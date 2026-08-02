@extends('layouts.app')

@section('content')

<h1 class="mb-4">Journal des activités</h1>

<div class="card">

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>

            </thead>

            <tbody>

                @forelse($logs as $log)

                    <tr>

                        <td>{{ $log->id }}</td>

                        <td>
                            {{ $log->user->name ?? 'Utilisateur supprimé' }}
                        </td>

                        <td>
                            {{ $log->action }}
                        </td>

                        <td>
                            {{ $log->created_at }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Aucun journal disponible
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<br>

<a href="/admin/dashboard" class="btn btn-secondary">
    Retour au tableau de bord
</a>

@endsection