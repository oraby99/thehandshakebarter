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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('condition'); // new, like_new, used, damaged
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->string('location_city')->nullable();
            $table->string('location_area')->nullable();
            $table->string('status')->default('active'); // draft, active, archived, traded
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
