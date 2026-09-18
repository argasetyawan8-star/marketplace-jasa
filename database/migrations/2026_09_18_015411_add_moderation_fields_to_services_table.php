<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('rejection_reason')
                ->nullable()
                ->after('status');

            $table->timestamp('submitted_at')
                ->nullable()
                ->after('rejection_reason');

            $table->timestamp('reviewed_at')
                ->nullable()
                ->after('submitted_at');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->after('reviewed_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);

            $table->dropColumn([
                'rejection_reason',
                'submitted_at',
                'reviewed_at',
                'reviewed_by',
            ]);
        });
    }
};