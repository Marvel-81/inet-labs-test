<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->resource['success'] ?? false,
            'message' => $this->resource['message'] ?? __('messages.error'),
            'error_code' => $this->resource['error_code'] ?? 'SERVER_ERROR',
            'debug' => $this->resource['debug'] ?? null,
        ];
    }
}
