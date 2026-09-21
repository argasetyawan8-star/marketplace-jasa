<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();

            $table->string('dispute_number', 50)
                ->unique();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('opened_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('opened_by_role', 30);

            $table->string('category', 60);

            $table->text('reason');

            $table->string('status', 40)
                ->default('open');

            $table->string('resolution', 40)
                ->nullable();

            $table->text('resolution_note')
                ->nullable();

            $table->foreignId('resolved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('resolved_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'order_id',
                'status',
            ]);

            $table->index([
                'opened_by',
                'opened_by_role',
            ]);

            $table->index('resolution');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};