<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class LeadController extends Controller
{
    protected LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Создание нового лида
     * @param LeadRequest $request
     * @return JsonResponse
     */
    public function store(LeadRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $lead = $this->leadService->createLead($validated);

            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно создана',
                'data' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'phone' => $lead->phone,
                    'email' => $lead->email,
                    'created_at' => $lead->created_at->toISOString(),
                ],
            ], 201);

        } catch (Throwable $e) {
            Log::error('Lead creation error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при создании заявки',
                'error_code' => 'SERVER_ERROR',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
