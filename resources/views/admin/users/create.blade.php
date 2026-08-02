<h1>Ajouter un utilisateur</h1>

<form method="POST" action="/admin/users/store">
    @csrf

    <label>Nom</label><br>
    <input type="text" name="name" required>
    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Mot de passe</label><br>
    <input type="password" name="password" required>
    <br><br>

    <label>Rôle</label><br>
    <select name="role_id">
        @foreach($roles as $role)
            <option value="{{ $role->id }}">
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">
        Enregistrer
    </button>
</form>

<br>

<a href="/admin/users">
    Retour à la liste
</a>