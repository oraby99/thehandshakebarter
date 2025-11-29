<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('content');
        });

        // Check if benefits column exists in subscriptions table, if not add it
        if (!Schema::hasColumn('subscriptions', 'benefits')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->json('benefits')->nullable()->after('currency');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });

        if (Schema::hasColumn('subscriptions', 'benefits')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('benefits');
            });
        }
    }
};
