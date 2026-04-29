<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('appointments') || Schema::hasColumn('appointments', 'clinic_id')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('clinic_id')->nullable()->after('doctor_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('appointments') || !Schema::hasColumn('appointments', 'clinic_id')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('clinic_id');
        });
    }
};
