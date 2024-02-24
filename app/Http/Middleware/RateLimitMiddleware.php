<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next, $maxAttempts = 2, $decayMinutes = 1)
    {
        $key = $request->ip(); // Menggunakan alamat IP pengguna sebagai kunci

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return new Response('Terlalu banyak permintaan.', 429); // 429 Too Many Requests
        }

        $this->limiter->hit($key, $decayMinutes);

        return $next($request);
    }
}