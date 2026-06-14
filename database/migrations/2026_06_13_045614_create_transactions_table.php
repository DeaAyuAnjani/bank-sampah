<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('waste_category_id')->constrained('waste_categories');
            $table->decimal('weight', 10, 2);
            $table->decimal('price_per_kg', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->decimal('pickup_fee', 12, 2)->default(0);
            $table->decimal('final_amount', 12, 2);
            $table->enum('transaction_type', ['pickup', 'antar_sendiri']);
            $table->enum('status', ['pending', 'verified', 'completed', 'rejected'])->default('pending');
            $table->string('qr_code_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};