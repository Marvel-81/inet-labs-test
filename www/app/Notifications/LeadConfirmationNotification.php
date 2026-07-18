<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Lead;

class LeadConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('messages.emails.lead_confirmation.subject'))
            ->view('emails.lead.confirmation', [
                'lead' => $this->lead,
            ]);
    }
}
