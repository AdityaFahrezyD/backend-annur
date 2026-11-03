<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicApiCache
{
    public function version(string $scope): int
    {
        return (int) Cache::get($this->versionKey($scope), 1);
    }

    /** @return array{content: string, status: int, content_type: string}|null */
    public function getResponse(string $scope, array $query, int $version, array $routeParameters = []): ?array
    {
        $response = Cache::get($this->cacheKey($scope, $query, $version, $routeParameters));

        return is_array($response) ? $response : null;
    }

    /** @param array{content: string, status: int, content_type: string} $response */
    public function putResponse(
        string $scope,
        array $query,
        array $response,
        int $version,
        array $routeParameters = [],
    ): void {
        $ttl = (int) config('api-cache.public_ttl', 0);

        if ($ttl > 0) {
            Cache::put($this->cacheKey($scope, $query, $version, $routeParameters), $response, $ttl);
        }
    }

    public function invalidate(string ...$scopes): void
    {
        DB::afterCommit(function () use ($scopes): void {
            foreach (array_unique($scopes) as $scope) {
                $versionKey = $this->versionKey($scope);

                Cache::add($versionKey, 1);
                Cache::increment($versionKey);
            }
        });
    }

    private function cacheKey(string $scope, array $query, int $version, array $routeParameters): string
    {
        ksort($query);
        ksort($routeParameters);

        $keyData = $routeParameters === []
            ? $query
            : ['route' => $routeParameters, 'query' => $query];

        $queryHash = hash('sha256', json_encode($keyData, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE));

        return "public-api:{$scope}:v{$version}:{$queryHash}";
    }

    private function versionKey(string $scope): string
    {
        return "public-api:version:{$scope}";
    }
}
