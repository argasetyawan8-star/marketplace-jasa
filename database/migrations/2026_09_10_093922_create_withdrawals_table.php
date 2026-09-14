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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->cascadeOnDelete();

            $table->decimal('amount', 15, 2);

            $table->decimal('admin_fee', 15, 2)->default(0);

            $table->decimal('net_amount', 15, 2);

            $table->string('method');

            $table->string('account_name');

            $table->string('account_number');

            $table->text('note')->nullable();

            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'rejected',
            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};