<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\LeadCollectionResource;
use App\Http\Resources\LeadResource;
use App\Http\Resources\SuccessResource;
use App\Services\AIService;
use App\Services\LeadAICommentService;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class LeadController extends Controller
{
    private LeadService $leadService;
    private AIService $aiService;
    private LeadAICommentService $leadAIComment;

    public function __construct(
        LeadService $leadService,
        AIService $aIService,
        LeadAICommentService $leadAIComment
    ) {
        $this->leadService = $leadService;
        $this->aiService = $aIService;
        $this->leadAIComment = $leadAIComment;
    }

    /**
     * Создание нового лида
     * @return JsonResponse
     */
    public function store(LeadRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $lead = $this->leadService->createLead($data);
            $tone = $this->aiService->toneAnalyzer($data['comment']);
            $this->leadAIComment->createComment($lead->id, $tone);

            return (new SuccessResource([
                'message' => 'Заявка успешно создана',
                'data' => new LeadResource($lead),
            ]))->response()->setStatusCode(201);

        } catch (Throwable $e) {
            Log::error('Lead creation error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return (new ErrorResource([
                'message' => 'Произошла ошибка при создании заявки',
                'error_code' => 'SERVER_ERROR',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ]))->response()->setStatusCode(500);
        }
    }

    /**
     * Получение списка всех лидов с ИИ аналитикой
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $leads = $this->leadService->getAllLeadsWithAnalytics();

            if ($leads->isEmpty()) {
                $message = 'Лиды не найдены';
            }

            return (new SuccessResource([
                'message' => $message ?? 'Список лидов получен успешно',
                'data' => new LeadCollectionResource($leads),
            ]))->response()->setStatusCode(200);

        } catch (Throwable $e) {
            Log::error('Failed to get leads: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return (new ErrorResource([
                'message' => 'Ошибка получения списка лидов',
                'error_code' => 'SERVER_ERROR',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ]))->response()->setStatusCode(500);
        }
    }
}
