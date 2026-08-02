<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Liste des tâches</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,
        td{
            border:1px solid #000;
            padding:8px;
            text-align:left;
        }

        th{
            background:#eeeeee;
        }

    </style>

</head>

<body>

    <h2>Liste des tâches</h2>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Projet</th>
                <th>Assignée à</th>
                <th>Statut</th>
                <th>Date limite</th>
            </tr>

        </thead>

        <tbody>

            @foreach($tasks as $task)

            <tr>

                <td>{{ $task->id }}</td>

                <td>{{ $task->title }}</td>

                <td>{{ $task->project->title ?? '' }}</td>

                <td>{{ $task->assignedUser->name ?? '' }}</td>

                <td>{{ $task->status }}</td>

                <td>{{ $task->deadline }}</td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>
