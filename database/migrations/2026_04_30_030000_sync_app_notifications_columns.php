<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('app_notifications')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('app_notifications', 'type')) {
                $table->string('type')->default('info')->after('appointment_id');
            }
            if (!Schema::hasColumn('app_notifications', 'title')) {
                $table->string('title')->after('type');
            }
            if (!Schema::hasColumn('app_notifications', 'message')) {
                $table->text('message')->after('title');
            }
            if (!Schema::hasColumn('app_notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('message');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('app_notifications')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            foreach (['read_at', 'message', 'title', 'type'] as $column) {
                if (Schema::hasColumn('app_notifications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
