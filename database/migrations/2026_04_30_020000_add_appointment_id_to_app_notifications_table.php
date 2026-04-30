<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('app_notifications') || Schema::hasColumn('app_notifications', 'appointment_id')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->foreignId('appointment_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('app_notifications') || !Schema::hasColumn('app_notifications', 'appointment_id')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('appointment_id');
        });
    }
};
