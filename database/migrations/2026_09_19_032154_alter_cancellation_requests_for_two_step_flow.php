<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cancellation_requests', function (Blueprint $table) {
            /*
            |--------------------------------------------------------------------------
            | Ubah status dari enum menjadi string
            |--------------------------------------------------------------------------
            |
            | Kita membutuhkan beberapa status tambahan untuk alur:
            | Client -> Freelancer -> Mediasi Admin.
            |
            */
            $table->string('status', 40)
                ->default('pending_freelancer')
                ->change();

            $table->text('freelancer_note')
                ->nullable()
                ->after('reason');

            $table->timestamp('freelancer_reviewed_at')
                ->nullable()
                ->after('freelancer_note');

            $table->text('mediation_reason')
                ->nullable()
                ->after('admin_note');

            $table->timestamp('mediation_requested_at')
                ->nullable()
                ->after('mediation_reason');
        });

        /*
        |--------------------------------------------------------------------------
        | Migrasi data Cancellation versi lama
        |--------------------------------------------------------------------------
        */

        DB::table('cancellation_requests')
            ->where('status', 'pending')
            ->update([
                'status' => 'pending_freelancer',
            ]);

        DB::table('cancellation_requests')
            ->where('status', 'approved')
            ->update([
                'status' => 'approved_by_admin',
            ]);

        DB::table('cancellation_requests')
            ->where('status', 'rejected')
            ->update([
                'status' => 'rejected_by_admin',
            ]);
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Kembalikan status baru ke status lama
        |--------------------------------------------------------------------------
        */

        DB::table('cancellation_requests')
            ->whereIn('status', [
                'pending_freelancer',
                'mediation_pending',
            ])
            ->update([
                'status' => 'pending',
            ]);

        DB::table('cancellation_requests')
            ->whereIn('status', [
                'approved_by_freelancer',
                'approved_by_admin',
            ])
            ->update([
                'status' => 'approved',
            ]);

        DB::table('cancellation_requests')
            ->whereIn('status', [
                'rejected_by_freelancer',
                'rejected_by_admin',
            ])
            ->update([
                'status' => 'rejected',
            ]);

        Schema::table('cancellation_requests', function (Blueprint $table) {
            $table->dropColumn([
                'freelancer_note',
                'freelancer_reviewed_at',
                'mediation_reason',
                'mediation_requested_at',
            ]);

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])
                ->default('pending')
                ->change();
        });
    }
};