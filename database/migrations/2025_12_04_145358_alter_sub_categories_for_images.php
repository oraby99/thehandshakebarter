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
        Schema::table('sub_categories', function (Blueprint $table) {
            // Drop old columns
            if (Schema::hasColumn('sub_categories', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
            if (Schema::hasColumn('sub_categories', 'is_active')) {
                $table->dropColumn('is_active');
            }

            // Add image column
            $table->string('image')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }
};
