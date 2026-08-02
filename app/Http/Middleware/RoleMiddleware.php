<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Sécurité : s'assurer que l'utilisateur a bien un role_id
        if (!$user->role_id) {
            abort(403, 'Accès interdit');
        }

        // Convertir les deux côtés en string pour éviter les problèmes de type (int vs string)
        $userRole = (string) $user->role_id;
        $allowedRoles = array_map('strval', $roles);

        if (!in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }
}