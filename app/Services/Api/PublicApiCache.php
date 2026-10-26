<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicApiCache
{
    /** @return array{content: string, status: int, content_type: string}|null */
    public function getResponse(string $scope, array $query): ?array
    {
        $response = Cache::get($this->cacheKey($scope, $query));

        return is_array($response) ? $response : null;
    }

    /** @param array{content: string, status: int, content_type: string} $response */
    public function putResponse(string $scope, array $query, array $response): void
    {
        $ttl = (int) config('api-cache.public_ttl', 0);

        if ($ttl > 0) {
            Cache::put($this->cacheKey($scope, $query), $response, $ttl);
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

    private function cacheKey(string $scope, array $query): string
    {
        ksort($query);

        $queryHash = hash('sha256', json_encode($query, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE));
        $version = (int) Cache::get($this->versionKey($scope), 1);

        return "public-api:{$scope}:v{$version}:{$queryHash}";
    }

    private function versionKey(string $scope): string
    {
        return "public-api:version:{$scope}";
    }
}
