<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Tigusigalpa\GigaChat\Laravel\GigaChat;
use Tigusigalpa\GigaChat\Exceptions\GigaChatException;

class GigaChatService
{
    public function ask(string $question): string
    {
        try {
            // Используем фасад для удобства
            $response = GigaChat::ask($question);

            return trim($response);

        } catch (GigaChatException $e) {
            Log::error('GigaChat Error: ' . $e->getMessage());
            return 'Нет ответа от ИИ';
        }
    }
}
