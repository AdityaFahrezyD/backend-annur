<?php

namespace App\Http\Middleware;

use App\Services\Api\PublicApiCache;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CachePublicApiResponse
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        $ttl = (int) config('api-cache.public_ttl', 0);
        $route = $request->route();

        if (! $request->isMethod('GET') || $ttl <= 0 || $route === null) {
            return $next($request);
        }

        $scope = Str::after($route->uri(), 'api/');
        $cachedResponse = $this->publicApiCache->getResponse($scope, $request->query());

        if ($cachedResponse !== null) {
            return response($cachedResponse['content'], $cachedResponse['status'])
                ->header('Content-Type', $cachedResponse['content_type']);
        }

        $response = $next($request);

        if ($response instanceof JsonResponse && $response->isSuccessful()) {
            $this->publicApiCache->putResponse($scope, $request->query(), [
                'content' => $response->getContent(),
                'status' => $response->getStatusCode(),
                'content_type' => $response->headers->get('Content-Type', 'application/json'),
            ]);
        }

        return $response;
    }
}
