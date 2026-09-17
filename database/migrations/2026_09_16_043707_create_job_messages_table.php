<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_conversation_id')
                ->constrained('job_conversations')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('body');

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index([
                'job_conversation_id',
                'created_at',
            ]);

            $table->index([
                'user_id',
                'read_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_messages');
    }
};