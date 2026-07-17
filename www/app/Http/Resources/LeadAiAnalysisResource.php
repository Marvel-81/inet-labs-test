<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadAiAnalysisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parameter' => $this->parameter,
            'decoded_value' => $this->decoded_value,
            'confidence' => $this->confidence,
            'created_at' => $this->created_at->format('d.m.Y H:i'),
        ];
    }
}
