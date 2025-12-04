<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            if (Schema::hasColumn('items', 'is_visible')) {
                $table->dropColumn('is_visible');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);
        });
    }
};
