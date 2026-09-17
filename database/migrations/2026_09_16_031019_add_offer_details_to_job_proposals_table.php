<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_proposals', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('freelancer_profile_id');
            $table->string('phone', 30)->nullable()->after('display_name');
            $table->text('relevant_info')->nullable()->after('message');
            $table->string('portfolio_url')->nullable()->after('relevant_info');
            $table->foreignId('selected_experience_id')
                ->nullable()
                ->after('portfolio_url')
                ->constrained('freelancer_experiences')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('job_proposals', function (Blueprint $table) {
            $table->dropForeign(['selected_experience_id']);
            $table->dropColumn([
                'display_name',
                'phone',
                'relevant_info',
                'portfolio_url',
                'selected_experience_id',
            ]);
        });
    }
};