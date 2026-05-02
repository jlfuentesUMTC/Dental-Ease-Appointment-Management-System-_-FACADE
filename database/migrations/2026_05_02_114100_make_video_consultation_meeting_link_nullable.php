<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('video_consultations') || !Schema::hasColumn('video_consultations', 'meeting_link')) {
            return;
        }

        DB::statement('ALTER TABLE video_consultations MODIFY meeting_link VARCHAR(255) NULL');
    }

    public function down(): void
    {
        if (!Schema::hasTable('video_consultations') || !Schema::hasColumn('video_consultations', 'meeting_link')) {
            return;
        }

        DB::statement('ALTER TABLE video_consultations MODIFY meeting_link VARCHAR(255) NOT NULL');
    }
};
