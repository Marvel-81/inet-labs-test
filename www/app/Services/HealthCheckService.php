<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthCheckService
{
    /**
     * Run all health checks.
     */
    public function checkAll(): array
    {
        return [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'app' => $this->checkApp(),
        ];
    }

    /**
     * Check database connection.
     */
    public function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            Log::error('Database health check failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
            ];
        }
    }

    /**
     * Check cache connection.
     */
    public function checkCache(): array
    {
        try {
            Cache::store()->put('health_check', 'ok', 10);
            $cached = Cache::store()->get('health_check');

            if ($cached === 'ok') {
                return [
                    'status' => 'ok',
                    'message' => 'Cache connection successful',
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Cache read/write failed',
            ];
        } catch (\Exception $e) {
            Log::error('Cache health check failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Cache connection failed',
            ];
        }
    }

    /**
     * Check application status.
     */
    public function checkApp(): array
    {
        return [
            'status' => 'ok',
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
            'timezone' => config('app.timezone'),
        ];
    }

    /**
     * Check if all services are healthy.
     */
    public function isHealthy(): bool
    {
        $checks = $this->checkAll();
        return !collect($checks)->contains(fn ($check) => $check['status'] === 'error');
    }

    /**
     * Get health status summary.
     */
    public function getStatus(): array
    {
        $checks = $this->checkAll();
        $hasError = collect($checks)->contains(fn ($check) => $check['status'] === 'error');

        return [
            'status' => $hasError ? 'degraded' : 'ok',
            'timestamp' => now()->toISOString(),
            'checks' => $checks,
        ];
    }
}
