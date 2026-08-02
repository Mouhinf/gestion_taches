<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }
        .container{
            width:400px;
            margin:100px auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }
        input{
            width:100%;
            padding:10px;
            margin:10px 0;
        }
        button{
            width:100%;
            padding:10px;
            background:#007bff;
            color:white;
            border:none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Connexion</h2>

    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>