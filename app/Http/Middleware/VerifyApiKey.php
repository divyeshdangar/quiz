<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🔑 Get API key from request header or query param
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');

        // 🔑 Expected API key (set in .env: APP_API_KEY=MY_SECRET_KEY)
        $validKey = config('app.api_key', 'MY_SECRET_KEY');

        if ($apiKey !== $validKey) {
            return response()->json($resp = [
                "success" => false,
                "data" => null,
                "message" => "Unauthorized access. Invalid API key."
            ], 401);
        }

        return $next($request);
        return $next($request);
    }
}
