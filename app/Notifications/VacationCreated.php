<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Vacation;

class VacationCreated extends Notification
{
    use Queueable;

    public $vacation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Vacation $vacation)
    {
        $this->vacation = $vacation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacation_id' => $this->vacation->id,
            'user_name' => $this->vacation->user->name,
            'message' => 'Yeni bir izin talebi oluşturuldu.',
            'url' => route('dashboard'), // Admin goes to dashboard to see pending vacations
        ];
    }
}
