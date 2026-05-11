<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('pending')->after('role');
            }
            if (!Schema::hasColumn('users', 'government_id_path')) {
                $table->string('government_id_path')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('users', 'business_permit_path')) {
                $table->string('business_permit_path')->nullable()->after('government_id_path');
            }
            if (!Schema::hasColumn('users', 'clinic_image_path')) {
                $table->string('clinic_image_path')->nullable()->after('business_permit_path');
            }
            if (!Schema::hasColumn('users', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('clinic_image_path');
            }
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_notes');
            }
        });

        DB::table('users')
            ->where('role', 'admin')
            ->update([
                'verification_status' => 'approved',
                'verified_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('users', 'verified_at') ? 'verified_at' : null,
                Schema::hasColumn('users', 'verification_notes') ? 'verification_notes' : null,
                Schema::hasColumn('users', 'clinic_image_path') ? 'clinic_image_path' : null,
                Schema::hasColumn('users', 'business_permit_path') ? 'business_permit_path' : null,
                Schema::hasColumn('users', 'government_id_path') ? 'government_id_path' : null,
                Schema::hasColumn('users', 'verification_status') ? 'verification_status' : null,
            ]);

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
