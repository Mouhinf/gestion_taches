<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','TaskFlow')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

</head>

<body>

<div class="wrapper">

    <!-- Sidebar -->

    <aside class="sidebar">

        <div class="logo">

            <h3>
                <i class="bi bi-kanban-fill"></i>
                TaskFlow
            </h3>

        </div>

        <ul>

            <li>

                <a href="/{{ auth()->user()->role_id==1?'admin':(auth()->user()->role_id==2?'manager':'user') }}/dashboard">

                    <i class="bi bi-grid-fill"></i>

                    Tableau de bord

                </a>

            </li>


            @if(auth()->user()->role_id==1)

            <li>

                <a href="/admin/users">

                    <i class="bi bi-people-fill"></i>

                    Utilisateurs

                </a>

            </li>

            <li>

                <a href="/admin/projects">

                    <i class="bi bi-folder-fill"></i>

                    Projets

                </a>

            </li>

            <li>

                <a href="/admin/tasks">

                    <i class="bi bi-list-task"></i>

                    Tâches

                </a>

            </li>

            <li>

                <a href="/admin/tasks/kanban">

                    <i class="bi bi-columns-gap"></i>

                    Kanban

                </a>

            </li>

            <li>

                <a href="/admin/activity-logs">

                    <i class="bi bi-clock-history"></i>

                    Journal

                </a>

            </li>

            @endif


            @if(auth()->user()->role_id==2)

            <li>

                <a href="/admin/tasks/kanban">

                    <i class="bi bi-columns-gap"></i>

                    Kanban

                </a>

            </li>

            @endif


            @if(auth()->user()->role_id==3)

            <li>

                <a href="/user/dashboard">

                    <i class="bi bi-list-task"></i>

                    Mes tâches

                </a>

            </li>

            @endif


            <li class="logout">

                <a href="/logout">

                    <i class="bi bi-box-arrow-right"></i>

                    Déconnexion

                </a>

            </li>

        </ul>

    </aside>



    <!-- CONTENU -->

    <div class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h3>

                    Bonjour {{ auth()->user()->name }}

                    👋

                </h3>

                <small>

                    Bienvenue sur votre plateforme de gestion des tâches.

                </small>

            </div>

            <div class="profile">

                <i class="bi bi-person-circle"></i>

                {{ auth()->user()->name }}

            </div>

        </div>



        <!-- Contenu -->

        <div class="page-content">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif


            @yield('content')

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

</body>

</html>