<?php

namespace App\Services;

use App\Interfaces\AIServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class AIService
{
    private AIServiceInterface $ai;

    public function __construct(AIServiceInterface $AIservice)
    {
        $this->ai = $AIservice;
    }
    /**
     * Запрос на получение тональности комментария
     * @param string $comment Текст сообщения
     * @return array Тональность/оценка
     */
    public function toneAnalyzer(string $comment): array
    {
        $question = "Проанализируй тональность коментария";
        try {
            $tone = $this->ai->ask($question.": \"$comment\"");
        } catch (Exception $e) {

            Log::error('AI tone analysis failed', [
                'error_message' => $e->getMessage(),
            ]);

            $tone = "Тональность не проанализирована";
        }
        return [
            'parameter' => 'Тональность',
            'value' => $tone ?? "Тональность не проанализирована"
            ];
    }
}
