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
        Schema::create('freelancer_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('username')->unique();
            $table->string('headline')->nullable();

            $table->text('bio')->nullable();

            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();

            $table->string('location')->nullable();
            $table->string('website')->nullable();

            $table->unsignedInteger('completed_orders')->default(0);
            $table->decimal('rating', 3, 2)->default(0);

            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_profiles');
    }
};