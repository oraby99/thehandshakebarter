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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('barter_id')->nullable()->constrained()->nullOnDelete();
            // We will add subscription_plan_id or user_subscription_id later if needed, or just rely on metadata/type.
            // But let's add subscription_plan_id for clarity as per plan.
            $table->unsignedBigInteger('subscription_plan_id')->nullable(); // No constraint yet as table might not exist or circular dep.
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('USD');
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending'); // pending, succeeded, failed, refunded
            $table->string('provider_reference')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
