<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('rating');

            $table->text('comment')
                ->nullable();

            $table->string('status')
                ->default('published');

            $table->text('admin_note')
                ->nullable();

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};