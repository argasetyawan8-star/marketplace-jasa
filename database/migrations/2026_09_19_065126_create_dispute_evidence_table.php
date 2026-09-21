<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispute_evidences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dispute_id')
                ->constrained('disputes')
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('file_path', 2048);

            $table->string('file_name', 255);

            $table->string('mime_type', 120)
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->timestamps();

            $table->index([
                'dispute_id',
                'created_at',
            ]);

            $table->index('uploaded_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispute_evidences');
    }
};