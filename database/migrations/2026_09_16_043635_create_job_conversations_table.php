<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_conversations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('job_posts')
                ->cascadeOnDelete();

            $table->foreignId('job_proposal_id')
                ->constrained('job_proposals')
                ->cascadeOnDelete();

            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique('job_proposal_id');
            $table->index(['job_id', 'client_id']);
            $table->index(['job_id', 'freelancer_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_conversations');
    }
};