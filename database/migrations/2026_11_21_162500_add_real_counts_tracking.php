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
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'views_count')) {
                $table->unsignedInteger('views_count')->default(0)->after('description');
            }
            if (!Schema::hasColumn('documents', 'downloads_count')) {
                $table->unsignedInteger('downloads_count')->default(0)->after('views_count');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'followers_count')) {
                $table->unsignedInteger('followers_count')->default(0)->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('followers_count');
        });
    }
};
