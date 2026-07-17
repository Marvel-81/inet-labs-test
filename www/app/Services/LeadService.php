<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Получение списка лидов
     * @return Collection
     */
    public function getAllLeadsWithAnalytics(): Collection
    {
        return Lead::with(['aiAnalyses' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    }
}
