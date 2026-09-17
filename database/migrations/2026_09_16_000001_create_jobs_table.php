<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('subcategories')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description');

            $table->decimal('budget_min', 15, 2)
                ->nullable();

            $table->decimal('budget_max', 15, 2)
                ->nullable();

            $table->unsignedInteger('duration_days')
                ->nullable();

            $table->date('deadline')
                ->nullable();

            $table->string('location')
                ->nullable();

            $table->enum('status', [
                'draft',
                'open',
                'in_review',
                'closed',
                'cancelled',
            ])->default('draft');

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index(['category_id', 'subcategory_id']);
            $table->index('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};