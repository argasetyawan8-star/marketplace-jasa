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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();

            $table->string('service_title');

            $table->unsignedInteger('quantity')
                ->default(1);

            $table->decimal('unit_price', 15, 2);

            $table->decimal('subtotal', 15, 2);

            $table->unsignedInteger('delivery_days')
                ->default(1);

            $table->text('requirements')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Balikkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};