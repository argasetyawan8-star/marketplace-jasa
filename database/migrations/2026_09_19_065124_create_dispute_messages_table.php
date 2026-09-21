<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispute_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dispute_id')
                ->constrained('disputes')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('message');

            $table->timestamps();

            $table->index([
                'dispute_id',
                'created_at',
            ]);

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispute_messages');
    }
};