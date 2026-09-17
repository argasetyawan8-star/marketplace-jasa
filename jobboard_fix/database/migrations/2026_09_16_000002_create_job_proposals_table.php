<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('freelancer_profile_id')->constrained('freelancer_profiles')->cascadeOnDelete();
            $table->decimal('price', 15, 2);
            $table->unsignedInteger('delivery_days');
            $table->text('message');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'withdrawn'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['job_id', 'freelancer_profile_id']);
            $table->index(['job_id', 'status']);
            $table->index(['freelancer_profile_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_proposals');
    }
};
