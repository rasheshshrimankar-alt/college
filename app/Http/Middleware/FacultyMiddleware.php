<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'faculty') {
            if ($request->expectsJson()) return response()->json(['message' => 'Unauthorized'], 403);
            return redirect()->route('login')->with('error', 'Access denied. Faculty only.');
        }
        return $next($request);
    }
}
