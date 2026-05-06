<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('app_notifications') || Schema::hasColumn('app_notifications', 'body')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->text('body')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('app_notifications') || !Schema::hasColumn('app_notifications', 'body')) {
            return;
        }

        Schema::table('app_notifications', function (Blueprint $table) {
            $table->dropColumn('body');
        });
    }
};
