<?php

namespace App\Observers;

use App\Models\Lead;
use App\Notifications\LeadCreatedNotification;
use App\Notifications\LeadConfirmationNotification;
use Illuminate\Support\Facades\Notification;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        $this->notifyAdmin($lead);

        if ($lead->email) {
            $this->notifyLead($lead);
        }
    }

    /**
     * Send notification to the site administrator.
     */
    private function notifyAdmin(Lead $lead): void
    {
        $adminEmail = config('mail.admin_email', 'admin@example.com');

        Notification::route('mail', $adminEmail)
            ->notify(new LeadCreatedNotification($lead));
    }

    /**
     * Send confirmation notification to the lead.
     */
    private function notifyLead(Lead $lead): void
    {
        $lead->notify(new LeadConfirmationNotification($lead));
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
    }

    /**
     * Handle the Lead "forceDeleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
    }
}
