<?php

namespace App\Models;

use App\Events\AppointmentChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'clinic_id',
        'patient_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'clinic_name',
        'service',
        'appointment_date',
        'appointment_time',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    protected static function booted(): void
    {
        static::created(fn (Appointment $appointment) => $appointment->broadcastChange('created'));
        static::updated(fn (Appointment $appointment) => $appointment->broadcastChange('updated'));
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }

    public function videoConsultation(): HasOne
    {
        return $this->hasOne(VideoConsultation::class);
    }

    public function scopeLatestBooked(Builder $query): Builder
    {
        return $query
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    public function scopeForClinic(Builder $query, User $clinic): Builder
    {
        return $query->where(function ($query) use ($clinic) {
            $query->where('clinic_id', $clinic->id)
                ->orWhere(function ($legacyQuery) use ($clinic) {
                    $legacyQuery->whereNull('clinic_id')
                        ->where('clinic_name', $clinic->name);
                });
        });
    }

    public function belongsToClinic(User $clinic): bool
    {
        return $this->clinic_id === $clinic->id
            || ($this->clinic_id === null && $this->clinic_name === $clinic->name);
    }

    public function scheduledAt(): ?Carbon
    {
        if (!$this->appointment_date || !$this->appointment_time) {
            return null;
        }

        return $this->appointment_date->copy()->setTimeFrom($this->appointment_time);
    }

    public function videoHasEnded(): bool
    {
        $consultation = $this->videoConsultation;

        return $this->status === 'completed'
            || (bool) $consultation?->ended_at
            || in_array($consultation?->status, ['ended', 'completed'], true);
    }

    public function videoHasExpired(): bool
    {
        $scheduledAt = $this->scheduledAt();

        return $scheduledAt !== null && now()->greaterThan($scheduledAt->copy()->addHours(2));
    }

    public function canJoinVideoCall(): bool
    {
        if ($this->type !== 'Telehealth' || $this->status !== 'confirmed') {
            return false;
        }

        return !$this->videoHasEnded() && !$this->videoHasExpired();
    }

    public function patientCanJoinVideoCall(): bool
    {
        return $this->canJoinVideoCall() && (bool) $this->videoConsultation?->started_at;
    }

    private function broadcastChange(string $action): void
    {
        if (!$this->clinic_id && !$this->patient_id) {
            return;
        }

        try {
            broadcast(new AppointmentChanged($this, $action));
        } catch (\Throwable $exception) {
            Log::warning('Realtime appointment broadcast failed.', [
                'appointment_id' => $this->id,
                'action' => $action,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
