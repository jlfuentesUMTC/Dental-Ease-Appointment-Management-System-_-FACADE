<?php

namespace App\Events;

use App\Models\AppNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppNotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public AppNotification $notification)
    {
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('App.Models.User.'.$this->notification->user_id);
    }

    public function broadcastAs(): string
    {
        return 'app.notification.created';
    }

    public function broadcastWith(): array
    {
        $appointment = $this->notification->appointment;

        return [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'type' => $this->notification->type,
            'created_at' => $this->notification->created_at?->diffForHumans() ?? 'Just now',
            'appointment' => $appointment ? [
                'id' => $appointment->id,
                'status' => $appointment->status,
                'clinic_id' => $appointment->clinic_id,
                'patient_id' => $appointment->patient_id,
                'updated_at' => $appointment->updated_at?->toIso8601String(),
            ] : null,
        ];
    }
}
