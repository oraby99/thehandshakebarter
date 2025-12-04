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
        // Remove slug from all attribute tables
        $tables = ['brands', 'colors', 'cities', 'conditions', 'sizes', 'item_statuses', 'categories', 'sub_categories'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'slug')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('slug');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add slug columns
        $tables = ['brands', 'colors', 'cities', 'conditions', 'sizes', 'item_statuses', 'categories', 'sub_categories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('slug')->unique()->after('name');
            });
        }
    }
};
