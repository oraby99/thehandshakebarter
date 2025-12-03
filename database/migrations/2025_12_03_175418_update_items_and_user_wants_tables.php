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
        // Update items table
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('condition_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('item_status_id')->nullable()->constrained()->nullOnDelete();
        });

        // Migrate existing data for items
        $items = \DB::table('items')->get();
        foreach ($items as $item) {
            $condition = \DB::table('conditions')->where('name', $item->condition)->first();
            $size = \DB::table('sizes')->where('name', $item->size)->first();
            $brand = \DB::table('brands')->where('name', $item->brand)->first();
            // Map 'status' string to 'item_statuses' table
            // Assuming 'status' column in items was something like 'active', 'sold'
            $status = \DB::table('item_statuses')->where('name', $item->status)->first();

            \DB::table('items')->where('id', $item->id)->update([
                'condition_id' => $condition ? $condition->id : null,
                'size_id' => $size ? $size->id : null,
                'brand_id' => $brand ? $brand->id : null,
                'item_status_id' => $status ? $status->id : null,
            ]);
        }

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['condition', 'size', 'brand', 'status']);
        });

        // Update user_wants table
        Schema::table('user_wants', function (Blueprint $table) {
            $table->foreignId('condition_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            // user_wants might not have status, but let's check schema later. 
            // Assuming it has condition, size, brand based on user request.
        });

        // Migrate existing data for user_wants
        $wants = \DB::table('user_wants')->get();
        foreach ($wants as $want) {
            $condition = \DB::table('conditions')->where('name', $want->condition)->first();
            $size = \DB::table('sizes')->where('name', $want->size)->first();
            $brand = \DB::table('brands')->where('name', $want->brand)->first();

            \DB::table('user_wants')->where('id', $want->id)->update([
                'condition_id' => $condition ? $condition->id : null,
                'size_id' => $size ? $size->id : null,
                'brand_id' => $brand ? $brand->id : null,
            ]);
        }

        Schema::table('user_wants', function (Blueprint $table) {
            $table->dropColumn(['condition', 'size', 'brand']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('condition')->nullable();
            $table->string('size')->nullable();
            $table->string('brand')->nullable();
            $table->string('status')->default('active'); // Assuming default
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['size_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['item_status_id']);
            $table->dropColumn(['condition_id', 'size_id', 'brand_id', 'item_status_id']);
        });

        Schema::table('user_wants', function (Blueprint $table) {
            $table->string('condition')->nullable();
            $table->string('size')->nullable();
            $table->string('brand')->nullable();
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['size_id']);
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['condition_id', 'size_id', 'brand_id']);
        });
    }
};
