<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public string $action = 'updated'
    ) {
    }

    public function broadcastOn(): array
    {
        return collect([$this->appointment->clinic_id, $this->appointment->patient_id])
            ->filter()
            ->unique()
            ->map(fn ($userId) => new PrivateChannel('App.Models.User.'.$userId))
            ->all();
    }

    public function broadcastAs(): string
    {
        return 'appointment.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'appointment' => [
                'id' => $this->appointment->id,
                'status' => $this->appointment->status,
                'clinic_id' => $this->appointment->clinic_id,
                'patient_id' => $this->appointment->patient_id,
                'updated_at' => $this->appointment->updated_at?->toIso8601String(),
            ],
        ];
    }
}
