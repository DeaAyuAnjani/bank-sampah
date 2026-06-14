<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('waste_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('estimated_weight', 8, 2);

            $table->date('pickup_date');

            $table->text('address');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_requests');
    }
};