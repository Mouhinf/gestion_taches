<h1>Modifier utilisateur</h1>

<form method="POST" action="/admin/users/update/{{ $user->id }}">
    @csrf

    <label>Nom</label><br>
    <input type="text" name="name" value="{{ $user->name }}" required>

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ $user->email }}" required>

    <br><br>

    <label>Rôle</label><br>
    <select name="role_id">
        @foreach($roles as $role)
            <option value="{{ $role->id }}"
                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <button type="submit">Mettre à jour</button>
</form>

<br>

<a href="/admin/users">Retour à la liste</a>