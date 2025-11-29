<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Laravel doesn't support modifying ENUMs directly with ->change()
            // We use raw SQL to modify the ENUM column
            \DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive', 'banned') DEFAULT 'inactive'");
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            \DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'banned') DEFAULT 'active'");
        });
    }
};
