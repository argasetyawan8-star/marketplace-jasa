<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->restrictOnDelete();

            $table->string('order_number')
                ->unique();

            $table->string('status')
                ->default('pending_payment');

            $table->decimal('subtotal', 15, 2)
                ->default(0);

            $table->decimal('platform_fee', 15, 2)
                ->default(0);

            $table->decimal('total', 15, 2)
                ->default(0);

            $table->decimal('freelancer_amount', 15, 2)
                ->default(0);

            $table->text('requirements')
                ->nullable();

            $table->unsignedInteger('delivery_days')
                ->default(1);

            $table->timestamp('due_at')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->text('cancel_reason')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Balikkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};