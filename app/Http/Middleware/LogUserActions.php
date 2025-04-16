<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogUserActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $input = $request->path() === 'login' ? 'N/A' : $this->truncateInput($request->all() ?? []);

        Log::channel('user_actions')->info('User action', [
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'user_name' => Auth::check() ? Auth::user()->name : null,
            'url' => $request->fullUrl() ?? 'N/A',
            'method' => $request->method() ?? 'N/A',
            'ip' => $request->ip() ?? 'N/A',
            'input' => $input,
            'user_agent' => $request->header('User-Agent') ?? 'N/A',
            'status_code' => $response->getStatusCode() ?? 'N/A',
            'referer' => $request->header('referer') ?? 'N/A',
        ]);

        return $response;
    }

    /**
     * Truncate input values that are too long.
     *
     * @param  array  $input
     * @param  int  $maxLength
     * @return array
     */
    protected function truncateInput(array $input, int $maxLength = 10000): array
    {
        return array_map(function ($value) use ($maxLength) {
            if (is_string($value) && strlen($value) > $maxLength) {
                return substr($value, 0, $maxLength) . '...';
            }
            return $value;
        }, $input);
    }
}
