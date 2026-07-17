<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Log;
use Tigusigalpa\GigaChat\Laravel\GigaChat;
use Tigusigalpa\GigaChat\Exceptions\GigaChatException;
use App\Interfaces\AIServiceInterface;

class GigaChatService implements AIServiceInterface
{
    /**
     * Получение ответов от GigaChat
     * @param string $message
     * @return string|null
     */
    public function ask(string $message): ?string
    {
        try {
            $response = GigaChat::ask($message);

            return trim($response);

        } catch (GigaChatException $e) {
            Log::error('GigaChat Error: ' . $e->getMessage());
            return null;
        }
    }
}
