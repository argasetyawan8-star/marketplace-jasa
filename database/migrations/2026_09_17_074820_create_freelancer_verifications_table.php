<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freelancer_verifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('freelancer_profile_id')
                ->unique()
                ->constrained('freelancer_profiles')
                ->cascadeOnDelete();

            // Data identitas
            $table->string('full_name');
            $table->string('identity_type')->default('KTP');
            $table->text('identity_number');
            $table->string('identity_document_path')->nullable();

            // Data rekening
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->text('bank_account_number')->nullable();

            // Status verifikasi
            $table->enum('status', [
                'pending',
                'verified',
                'rejected',
            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            // Waktu proses
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            // Admin yang melakukan review
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_verifications');
    }
};