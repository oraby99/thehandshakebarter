<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_wants', function (Blueprint $table) {
            // Remove old fields
            $table->dropColumn(['title', 'min_price', 'max_price']);

            // Add new fields
            $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('sub_categories')->nullOnDelete();
            $table->string('condition')->nullable()->after('description'); // new, used, etc.
            $table->string('size')->nullable()->after('condition');
            $table->string('brand')->nullable()->after('size');
            $table->string('color')->nullable()->after('brand');
            $table->json('images')->nullable()->after('color');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->string('size')->nullable()->after('condition');
            $table->string('brand')->nullable()->after('size');
            $table->string('color')->nullable()->after('brand');
        });
    }

    public function down(): void
    {
        Schema::table('user_wants', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();

            $table->dropForeign(['sub_category_id']);
            $table->dropColumn(['sub_category_id', 'condition', 'size', 'brand', 'color', 'images']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['size', 'brand', 'color']);
        });
    }
};
