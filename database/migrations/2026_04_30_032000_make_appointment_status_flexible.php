<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('appointments') || !Schema::hasColumn('appointments', 'status')) {
            return;
        }

        DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(30) NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        if (!Schema::hasTable('appointments') || !Schema::hasColumn('appointments', 'status')) {
            return;
        }

        DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(30) NOT NULL DEFAULT 'pending'");
    }
};
