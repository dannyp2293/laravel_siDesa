<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {

        $roleName = Role::FIND(Auth::user()->role_id)->name;
        if(!Auth::check() || !in_array($roleName, $roles)){

    return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
