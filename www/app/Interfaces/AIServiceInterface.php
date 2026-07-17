<?php

namespace App\Interfaces;

interface AIServiceInterface
{
    /**
     * Получение ответов от ИИ
     * @param string $message
     * @return string|null
     */
    public function ask(string $message): ?string;
}
