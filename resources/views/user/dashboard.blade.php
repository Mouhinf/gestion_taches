@extends('layouts.app')

@section('content')

<h1 class="mb-4">Tableau de bord Utilisateur</h1>

<div class="card">

    <div class="card-header bg-primary text-white">
        Mes tâches
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>
                    <th>Tâche</th>
                    <th>Projet</th>
                    <th>Statut</th>
                    <th>Date limite</th>
                </tr>

            </thead>

            <tbody>

            @foreach($tasks as $task)

                <tr>

                    <td>{{ $task->title }}</td>

                    <td>{{ $task->project->title ?? '' }}</td>

                    <td>

                        @if($task->status == 'A faire')

                            <span class="badge bg-secondary">
                                A faire
                            </span>

                        @elseif($task->status == 'En cours')

                            <span class="badge bg-warning text-dark">
                                En cours
                            </span>

                        @elseif($task->status == 'Terminee')

                            <span class="badge bg-success">
                                Terminée
                            </span>

                        @else

                            <span class="badge bg-info">
                                {{ $task->status }}
                            </span>

                        @endif

                    </td>

                    <td>{{ $task->deadline }}</td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection