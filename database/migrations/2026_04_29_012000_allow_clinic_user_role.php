<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'role')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('patient', 'clinic', 'doctor', 'admin') NOT NULL DEFAULT 'patient'");
    }

    public function down(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'role')) {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('patient', 'doctor', 'admin') NOT NULL DEFAULT 'patient'");
    }
};
