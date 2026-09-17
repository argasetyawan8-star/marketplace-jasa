<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | OFFERS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('offers', 'job_id')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->foreignId('job_id')
                    ->nullable()
                    ->after('service_id')
                    ->constrained('job_posts')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('offers', 'job_proposal_id')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->foreignId('job_proposal_id')
                    ->nullable()
                    ->after('job_id')
                    ->constrained('job_proposals')
                    ->nullOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        |
        | conversation_id ternyata sudah ada di database,
        | jadi tidak perlu ditambahkan lagi.
        |
        */

        /*
        |--------------------------------------------------------------------------
        | ORDER ITEMS
        |--------------------------------------------------------------------------
        |
        | service_id harus bisa NULL karena Order dari Job Board
        | tidak selalu berasal dari Service.
        |
        */

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('service_id')
                ->nullable()
                ->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | OFFERS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('offers', 'job_proposal_id')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->dropForeign(['job_proposal_id']);
                $table->dropColumn('job_proposal_id');
            });
        }

        if (Schema::hasColumn('offers', 'job_id')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->dropForeign(['job_id']);
                $table->dropColumn('job_id');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER ITEMS
        |--------------------------------------------------------------------------
        */

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('service_id')
                ->nullable(false)
                ->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->restrictOnDelete();
        });
    }
};