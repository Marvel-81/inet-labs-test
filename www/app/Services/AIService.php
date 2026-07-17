<?php

namespace App\Services;

use App\Interfaces\AIServiceInterface;

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
        $tone = $this->ai->ask($question.": \"$comment\"");
        return [
            'parameter' => 'Тональность',
            'value' => $tone ?? "Тональность не проанализирована"
            ];
    }
}
