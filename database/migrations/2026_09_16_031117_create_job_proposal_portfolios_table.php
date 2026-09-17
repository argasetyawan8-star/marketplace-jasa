<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_proposal_portfolios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_proposal_id')
                ->constrained('job_proposals')
                ->cascadeOnDelete();

            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_proposal_portfolios');
    }
};