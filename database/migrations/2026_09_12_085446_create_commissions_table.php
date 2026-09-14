<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->restrictOnDelete();

            $table->decimal('order_total', 15, 2)
                ->default(0);

            $table->decimal('commission_rate', 5, 2)
                ->default(0);

            $table->decimal('commission_amount', 15, 2)
                ->default(0);

            $table->decimal('freelancer_amount', 15, 2)
                ->default(0);

            $table->string('status')
                ->default('pending');

            $table->timestamp('earned_at')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};