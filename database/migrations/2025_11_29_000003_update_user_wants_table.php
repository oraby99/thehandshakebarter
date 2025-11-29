<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_wants', function (Blueprint $table) {
            $table->string('title')->after('user_id');
            $table->text('description')->nullable()->after('title');
            $table->decimal('min_price', 10, 2)->nullable()->after('description');
            $table->decimal('max_price', 10, 2)->nullable()->after('min_price');
            // Keep category_id and specific_item_id as they are useful
        });
    }

    public function down(): void
    {
        Schema::table('user_wants', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'min_price', 'max_price']);
        });
    }
};
