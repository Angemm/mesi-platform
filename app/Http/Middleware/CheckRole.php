<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur possède l'un des rôles requis.
     * Usage dans routes: ->middleware('role:admin,editeur')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Accès non autorisé. Vous n\'avez pas les permissions nécessaires.');
        }

        return $next($request);
    }
}
