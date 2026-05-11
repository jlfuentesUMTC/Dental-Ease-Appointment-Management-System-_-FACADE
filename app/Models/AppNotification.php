<?php

namespace App\Models;

use App\Events\AppNotificationCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class AppNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_id',
        'type',
        'title',
        'body',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (AppNotification $notification): void {
            try {
                broadcast(new AppNotificationCreated($notification));
            } catch (\Throwable $exception) {
                Log::warning('Realtime notification broadcast failed.', [
                    'notification_id' => $notification->id,
                    'message' => $exception->getMessage(),
                ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
