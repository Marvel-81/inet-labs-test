<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Services\HealthCheckService;
use Illuminate\Http\JsonResponse;
use Throwable;

class HealthCheckController extends Controller
{
    protected HealthCheckService $healthCheckService;

    public function __construct(HealthCheckService $healthCheckService)
    {
        $this->healthCheckService = $healthCheckService;
    }

    /**
     * Проверка работоспособности сервиса
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $status = $this->healthCheckService->getStatus();

            if ($status['status'] === 'degraded') {
                return (new ErrorResource([
                    'message' => __('messages.health.degraded'),
                    'error_code' => 'HEALTH_CHECK_FAILED',
                    'debug' => $status ?? '',
                ]))->response()->setStatusCode(503);
            }

            return (new SuccessResource([
                'message' => __('messages.health.healthy'),
                'data' => $status,
            ]))->response()->setStatusCode(200);

        } catch (Throwable $e) {
            return (new ErrorResource([
                'message' => __('messages.health.error'),
                'error_code' => 'HEALTH_CHECK_ERROR',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ]))->response()->setStatusCode(500);
        }
    }
}
