@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Bienvenue -->

    <div class="mb-4">
        <h2 class="fw-bold">
            Bonjour {{ auth()->user()->name }} 👋
        </h2>
        <p class="text-muted">
            Voici un aperçu de votre plateforme de gestion des tâches.
        </p>
    </div>

    <!-- Cartes statistiques -->

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Utilisateurs</small>
                            <h2 class="fw-bold text-primary">{{ $usersCount }}</h2>
                        </div>
                        <i class="bi bi-people-fill text-primary" style="font-size:45px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Projets</small>
                            <h2 class="fw-bold text-success">{{ $projectsCount }}</h2>
                        </div>
                        <i class="bi bi-folder-fill text-success" style="font-size:45px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Tâches</small>
                            <h2 class="fw-bold text-warning">{{ $tasksCount }}</h2>
                        </div>
                        <i class="bi bi-list-task text-warning" style="font-size:45px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Terminées</small>
                            <h2 class="fw-bold text-info">{{ $completedTasks }}</h2>
                        </div>
                        <i class="bi bi-check-circle-fill text-info" style="font-size:45px;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Ligne principale -->

    <div class="row">

        <!-- Tâches récentes -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Tâches récentes</h5>
                </div>

                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Projet</th>
                                <th>Assigné</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentTasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->project->title ?? '-' }}</td>
                                <td>{{ $task->assignedUser->name ?? '-' }}</td>
                                <td>
                                    @if($task->status=="Terminée")
                                        <span class="badge bg-success">Terminée</span>
                                    @elseif($task->status=="En cours")
                                        <span class="badge bg-warning text-dark">En cours</span>
                                    @else
                                        <span class="badge bg-secondary">À faire</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Colonne droite -->
        <div class="col-lg-4">

            <!-- Graphique -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <canvas id="tasksChart"></canvas>
                </div>
            </div>

            <!-- Raccourcis -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Raccourcis</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="/admin/users" class="btn btn-primary">👥 Gérer les utilisateurs</a>
                    <a href="/admin/projects" class="btn btn-success">📁 Gérer les projets</a>
                    <a href="/admin/tasks" class="btn btn-warning">✅ Gérer les tâches</a>
                    <a href="/admin/activity-logs" class="btn btn-info text-white">📋 Journal d'activités</a>
                </div>
            </div>

        </div>

    </div>

    <!-- Calendrier des tâches -->

    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold mb-0">📅 Calendrier des tâches</h5>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

</div>

<!-- Librairies nécessaires (CSS + JS) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // --- Graphique Chart.js ---
    const ctx = document.getElementById('tasksChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['A faire', 'En cours', 'Terminée'],
            datasets: [{
                data: [
                    {{ $pendingTasks }},
                    {{ $inProgressTasks }},
                    {{ $completedTasks }}
                ],
                backgroundColor: ['#6c757d', '#ffc107', '#198754'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '65%'
        }
    });

    // --- Calendrier FullCalendar ---
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        initialView: 'dayGridMonth',
        height: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($calendarEvents),
        eventClick: function (info) {
            alert(
                "Tâche : " + info.event.title +
                "\nDate limite : " +
                info.event.start.toLocaleDateString('fr-FR')
            );
        }
    });

    calendar.render();

});
</script>

@endsection