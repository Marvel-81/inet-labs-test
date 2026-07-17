<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadAiAnalyses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class LeadAICommentService
{
    /**
     * Создание нового комментария, сделанного AI
     * @param int $lead_id
     * @param array $comment
     * @return LeadAiAnalyses|null
     * @throws Throwable
     */
    public function createComment(int $lead_id, array $comment): LeadAiAnalyses
    {
        try {
            DB::beginTransaction();

            $lead = LeadAiAnalyses::create([
                'lead_id' => $lead_id,
                'parameter' => $comment['parameter'],
                'decoded_value' => $comment['value'],
            ]);

            DB::commit();

            return $lead;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Lead creation failed: ' . $e->getMessage(), [
                'data' => $comment,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
