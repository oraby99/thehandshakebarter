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
        Schema::table('users', function (Blueprint $table) {
            // Add city_id foreign key
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete()->after('address');

            // Drop old city text column
            if (Schema::hasColumn('users', 'city')) {
                $table->dropColumn('city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
