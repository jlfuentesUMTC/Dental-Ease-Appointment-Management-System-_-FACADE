<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('app_notifications') || !Schema::hasColumn('app_notifications', 'body')) {
            return;
        }

        DB::statement('ALTER TABLE app_notifications MODIFY body TEXT NULL');
    }

    public function down(): void
    {
        if (!Schema::hasTable('app_notifications') || !Schema::hasColumn('app_notifications', 'body')) {
            return;
        }

        DB::statement('ALTER TABLE app_notifications MODIFY body TEXT NOT NULL');
    }
};
