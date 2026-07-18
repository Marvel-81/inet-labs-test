<?php

namespace App\Jobs;

use App\Services\AIService;
use App\Services\LeadAICommentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeToneJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $leadId;
    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(int $leadId, array $data)
    {
        $this->leadId = $leadId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(AIService $aiService, LeadAICommentService $leadAIComment): void
    {
        try {
            $tone = $aiService->toneAnalyzer($this->data['comment']);
            $leadAIComment->createComment($this->leadId, $tone);

        } catch (\Throwable $e) {
            Log::error('Failed to analyze tone', [
                'lead_id' => $this->leadId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
