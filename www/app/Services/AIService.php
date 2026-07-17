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
     * @return string Тональность
     */
    public function toneAnalyzer(string $comment): string
    {
        $question = "Проанализируй тональность коментария";
        $tone = $this->ai->ask($question.": \"$comment\"");
        return $tone ?? "Тональность не проанализирована";
    }
}
