<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('estimated_value');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->json('video_urls')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('estimated_value', 10, 2)->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('video_urls');
            $table->string('video_url')->nullable();
        });
    }
};
