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
        Schema::create('barters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('requester_item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('receiver_item_id')->constrained('items')->cascadeOnDelete();
            $table->decimal('cash_adjustment', 10, 2)->default(0); // Positive means requester pays extra? Or specify who pays? Let's assume requester pays if positive.
            $table->enum('status', ['pending', 'accepted', 'rejected', 'waiting_payment', 'paid', 'in_progress', 'completed', 'disputed', 'cancelled'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barters');
    }
};
