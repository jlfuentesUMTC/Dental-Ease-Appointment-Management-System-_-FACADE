<?php

namespace App\Models;

use App\Events\AppointmentChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
