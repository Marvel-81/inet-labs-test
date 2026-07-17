<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAiAnalyses extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'lead_ai_analyses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lead_id',
        'parameter',
        'decoded_value',
    ];


    /**
     * Get the lead that owns the analysis.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

}
