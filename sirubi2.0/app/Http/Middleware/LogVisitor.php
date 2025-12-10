<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorLog;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah halaman yang dikunjungi adalah halaman "/" (landing page)
        // Laravel mengembalikan "" bila root (bukan "/")
        $path = $request->path(); // "" jika root
       
        if ($path === '/') {
            VisitorLog::create([
                'ip'         => $request->ip(),
                'url'        => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
