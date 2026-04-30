<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'doctor_id')) {
                    $table->foreignId('doctor_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn('appointments', 'patient_id')) {
                    $table->foreignId('patient_id')->nullable()->after('doctor_id')->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn('appointments', 'patient_name')) {
                    $table->string('patient_name')->after('patient_id');
                }
                if (!Schema::hasColumn('appointments', 'patient_email')) {
                    $table->string('patient_email')->after('patient_name');
                }
                if (!Schema::hasColumn('appointments', 'patient_phone')) {
                    $table->string('patient_phone')->nullable()->after('patient_email');
                }
                if (!Schema::hasColumn('appointments', 'clinic_name')) {
                    $table->string('clinic_name')->after('patient_phone');
                }
                if (!Schema::hasColumn('appointments', 'service')) {
                    $table->string('service')->after('clinic_name');
                }
                if (!Schema::hasColumn('appointments', 'appointment_date')) {
                    $table->date('appointment_date')->after('service');
                }
                if (!Schema::hasColumn('appointments', 'appointment_time')) {
                    $table->time('appointment_time')->nullable()->after('appointment_date');
                }
                if (!Schema::hasColumn('appointments', 'type')) {
                    $table->string('type')->default('In-Clinic')->after('appointment_time');
                }
                if (!Schema::hasColumn('appointments', 'status')) {
                    $table->string('status')->default('pending')->after('type');
                }
                if (!Schema::hasColumn('appointments', 'notes')) {
                    $table->text('notes')->nullable()->after('status');
                }
            });

            return;
        }

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_phone')->nullable();
            $table->string('clinic_name');
            $table->string('service');
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->string('type')->default('In-Clinic');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};