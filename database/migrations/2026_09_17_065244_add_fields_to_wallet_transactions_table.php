<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('wallet_transactions', 'wallet_id')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->foreignId('wallet_id')
                    ->after('id')
                    ->constrained('wallets')
                    ->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'type')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->string('type')
                    ->after('wallet_id');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'category')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->string('category')
                    ->after('type');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'amount')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->decimal('amount', 15, 2)
                    ->after('category');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'balance_after')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->decimal('balance_after', 15, 2)
                    ->after('amount');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'description')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->text('description')
                    ->nullable()
                    ->after('balance_after');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'reference_type')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->string('reference_type')
                    ->nullable()
                    ->after('description');
            });
        }

        if (!Schema::hasColumn('wallet_transactions', 'reference_id')) {
            Schema::table('wallet_transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('reference_id')
                    ->nullable()
                    ->after('reference_type');
            });
        }
    }

    public function down(): void
    {
        $columns = [
            'reference_id',
            'reference_type',
            'description',
            'balance_after',
            'amount',
            'category',
            'type',
            'wallet_id',
        ];

        foreach ($columns as $column) {
            if (Schema::hasColumn('wallet_transactions', $column)) {
                Schema::table('wallet_transactions', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};