<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('appointments') || !Schema::hasColumn('appointments', 'doctor_id')) {
            return;
        }

        DB::statement('ALTER TABLE appointments MODIFY doctor_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        if (!Schema::hasTable('appointments') || !Schema::hasColumn('appointments', 'doctor_id')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->nullable(false)->change();
        });
    }
};
