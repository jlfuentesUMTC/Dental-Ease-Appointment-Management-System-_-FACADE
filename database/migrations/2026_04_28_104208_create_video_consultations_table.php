<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('video_consultations')) {
            Schema::table('video_consultations', function (Blueprint $table) {
                if (!Schema::hasColumn('video_consultations', 'appointment_id')) {
                    $table->foreignId('appointment_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('video_consultations', 'room_code')) {
                    $table->string('room_code')->unique()->after('appointment_id');
                }
                if (!Schema::hasColumn('video_consultations', 'started_at')) {
                    $table->timestamp('started_at')->nullable()->after('room_code');
                }
                if (!Schema::hasColumn('video_consultations', 'ended_at')) {
                    $table->timestamp('ended_at')->nullable()->after('started_at');
                }
            });

            return;
        }

        Schema::create('video_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->string('room_code')->unique();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_consultations');
    }
};
