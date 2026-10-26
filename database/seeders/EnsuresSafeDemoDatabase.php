<?php

namespace Database\Seeders;

use RuntimeException;

trait EnsuresSafeDemoDatabase
{
    protected function ensureSafeDemoDatabase(): void
    {
        $isSafeTestingDatabase = app()->environment('testing')
            && config('database.default') === 'sqlite'
            && config('database.connections.sqlite.database') === ':memory:';
        $isOptedInLocalDatabase = app()->environment('local')
            && filter_var(env('ANNUR_SEED_DEMO_DATA', false), FILTER_VALIDATE_BOOL);

        if (! $isSafeTestingDatabase && ! $isOptedInLocalDatabase) {
            throw new RuntimeException(
                'Demo seeders require an in-memory testing database or ANNUR_SEED_DEMO_DATA=true in local.'
            );
        }
    }
}