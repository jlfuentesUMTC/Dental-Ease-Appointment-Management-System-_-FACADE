<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('appointments')) {
            return;
        }

        if (Schema::hasColumn('appointments', 'patient_id')) {
            DB::statement('ALTER TABLE appointments MODIFY patient_id BIGINT UNSIGNED NULL');
        }

        if (Schema::hasColumn('appointments', 'appointment_time')) {
            DB::statement('ALTER TABLE appointments MODIFY appointment_time TIME NULL');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('appointments')) {
            return;
        }

        if (Schema::hasColumn('appointments', 'patient_id')) {
            DB::statement('ALTER TABLE appointments MODIFY patient_id BIGINT UNSIGNED NOT NULL');
        }

        if (Schema::hasColumn('appointments', 'appointment_time')) {
            DB::statement('ALTER TABLE appointments MODIFY appointment_time TIME NOT NULL');
        }
    }
};
