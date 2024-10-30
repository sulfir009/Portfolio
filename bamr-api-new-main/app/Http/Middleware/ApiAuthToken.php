<?php

namespace App\Http\Middleware;

use App\Models\Affiliates;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthToken
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('API-Key');
        $affiliates = Affiliates::where('api_key', $token)->first();

        if (!$affiliates) {
            return response()->json(['message' => 'Invalid API token'], 401);
        }

        return $next($request);
    }
}
