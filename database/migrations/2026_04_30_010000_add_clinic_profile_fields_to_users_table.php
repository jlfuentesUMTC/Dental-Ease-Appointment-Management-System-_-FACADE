<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'clinic_location')) {
                $table->string('clinic_location')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'clinic_hours')) {
                $table->string('clinic_hours')->nullable()->after('clinic_location');
            }
            if (!Schema::hasColumn('users', 'clinic_services')) {
                $table->json('clinic_services')->nullable()->after('clinic_hours');
            }
            if (!Schema::hasColumn('users', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('clinic_services');
            }
            if (!Schema::hasColumn('users', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('users', 'clinic_services') ? 'clinic_services' : null,
                Schema::hasColumn('users', 'longitude') ? 'longitude' : null,
                Schema::hasColumn('users', 'latitude') ? 'latitude' : null,
                Schema::hasColumn('users', 'clinic_hours') ? 'clinic_hours' : null,
                Schema::hasColumn('users', 'clinic_location') ? 'clinic_location' : null,
            ]);

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
