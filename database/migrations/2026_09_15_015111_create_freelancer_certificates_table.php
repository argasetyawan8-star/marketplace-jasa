<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freelancer_profile_id')
                ->constrained('freelancer_profiles')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('issuer')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('credential_url')->nullable();

            $table->timestamps();

            $table->index('freelancer_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer_certificates');
    }
};