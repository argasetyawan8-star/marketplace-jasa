<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status', [
                'submitted',
                'approved',
                'revision',
                'rejected',
            ])->default('submitted')->change();
        });
    }

    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status', [
                'submitted',
                'approved',
                'rejected',
            ])->default('submitted')->change();
        });
    }
};