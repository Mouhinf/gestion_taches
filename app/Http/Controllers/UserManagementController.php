<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('role')

            ->when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");

            })

            ->orderBy('id', 'desc')

            ->paginate(10)

            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'search'
        ));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'role_id' => 'required|exists:roles,id',

        ]);

        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role_id' => $request->role_id

        ]);

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Création de l\'utilisateur : '.$user->name

        ]);

        return redirect('/admin/users')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Protection de l'administrateur
        if ($user->role_id == 1) {
            return redirect('/admin/users')
                ->with('error', 'Impossible de modifier un administrateur.');
        }

        $roles = Role::all();

        return view('admin.users.edit', compact(
            'user',
            'roles'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Protection de l'administrateur
        if ($user->role_id == 1) {
            return redirect('/admin/users')
                ->with('error', 'Impossible de modifier un administrateur.');
        }

        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email,'.$user->id,

            'role_id' => 'required|exists:roles,id',

        ]);

        $user->update([

            'name' => $request->name,

            'email' => $request->email,

            'role_id' => $request->role_id

        ]);

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Modification de l\'utilisateur : '.$user->name

        ]);

        return redirect('/admin/users')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Protection de l'administrateur
        if ($user->role_id == 1) {
            return redirect('/admin/users')
                ->with('error', 'Impossible de supprimer un administrateur.');
        }

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => 'Suppression de l\'utilisateur : '.$user->name

        ]);

        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}