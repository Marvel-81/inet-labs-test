<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class LeadService
{
    /**
     * Создание нового лида
     * @param array $data Данные для создания
     * @return Lead|null
     * @throws \Throwable
     */
    public function createLead(array $data): Lead
    {
        try {
            DB::beginTransaction();

            $lead = Lead::create($data);

            DB::commit();

            return $lead;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Lead creation failed: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
