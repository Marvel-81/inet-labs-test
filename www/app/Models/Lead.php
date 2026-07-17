<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Lead extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'leads';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'comment',
    ];

    /**
     * Get the email address for notifications.
     * Используется для отправки уведомлений самому лиду
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }

    /**
     * Собирает все расшифровки по данному лиду, сделанные ИИ
     */
    public function aiAnalyses(): HasMany
    {
        return $this->hasMany(LeadAiAnalysis::class);
    }
}
