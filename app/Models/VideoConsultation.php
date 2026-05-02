<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'meeting_link',
        'meeting_room',
        'room_code',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getJitsiRoomAttribute(): string
    {
        return $this->room_code ?: $this->meeting_room;
    }
}
