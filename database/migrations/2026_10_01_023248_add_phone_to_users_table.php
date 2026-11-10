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
        | Email nullable
        |--------------------------------------------------------------------------
        | Karena user boleh register menggunakan nomor telepon saja.
        */

        if (
            Schema::hasColumn(
                'users',
                'email'
            )
        ) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    $table
                        ->string('email')
                        ->nullable()
                        ->change();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Phone
        |--------------------------------------------------------------------------
        */

        if (
            ! Schema::hasColumn(
                'users',
                'phone'
            )
        ) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    $table
                        ->string(
                            'phone',
                            30
                        )
                        ->nullable()
                        ->unique()
                        ->after('email');
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Phone verified at
        |--------------------------------------------------------------------------
        */

        if (
            ! Schema::hasColumn(
                'users',
                'phone_verified_at'
            )
        ) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    $afterColumn = Schema::hasColumn(
                        'users',
                        'email_verified_at'
                    )
                        ? 'email_verified_at'
                        : 'email';

                    $table
                        ->timestamp(
                            'phone_verified_at'
                        )
                        ->nullable()
                        ->after(
                            $afterColumn
                        );
                }
            );
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remove phone_verified_at
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'users',
                'phone_verified_at'
            )
        ) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    $table->dropColumn(
                        'phone_verified_at'
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove phone
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'users',
                'phone'
            )
        ) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    $table->dropUnique(
                        'users_phone_unique'
                    );

                    $table->dropColumn(
                        'phone'
                    );
                }
            );
        }
    }
};