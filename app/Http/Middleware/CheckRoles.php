<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\UserModule;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *@param  String $module
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module): Response
    {
        if(Auth::user()->role == 'Administrador') return $next($request);

        if(UserModule::where('user_id', Auth::user()->id)->whereHas('module', function($query) use ($module){$query->where('internal_name', $module);})->exists()) return $next($request);

        return redirect()->route('panel')->with([
            'message' => 'No tienes permisos para acceder a este módulo',
            'type' => 'danger',
        ], 403);
    }
}
