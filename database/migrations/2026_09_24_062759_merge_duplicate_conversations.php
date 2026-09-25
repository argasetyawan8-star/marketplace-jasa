<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Cari semua kombinasi:
         *
         * client + freelancer
         *
         * yang memiliki lebih dari satu conversation.
         */
        $duplicateGroups = DB::table('conversations')
            ->select(
                'client_id',
                'freelancer_profile_id'
            )
            ->groupBy(
                'client_id',
                'freelancer_profile_id'
            )
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateGroups as $group) {

            $conversations = DB::table('conversations')
                ->where(
                    'client_id',
                    $group->client_id
                )
                ->where(
                    'freelancer_profile_id',
                    $group->freelancer_profile_id
                )
                ->orderByDesc('last_message_at')
                ->orderByDesc('updated_at')
                ->orderBy('id')
                ->get();

            if ($conversations->count() <= 1) {
                continue;
            }

            /*
             * Conversation pertama menjadi
             * conversation utama.
             */
            $primary = $conversations->first();

            $duplicateIds = $conversations
                ->skip(1)
                ->pluck('id');

            foreach ($duplicateIds as $duplicateId) {

                /*
                 * Pindahkan semua message ke conversation utama.
                 */
                if (Schema::hasColumn('messages', 'conversation_id')) {

                    DB::table('messages')
                        ->where(
                            'conversation_id',
                            $duplicateId
                        )
                        ->update([
                            'conversation_id' =>
                                $primary->id,
                        ]);
                }

                /*
                 * Pindahkan semua offer ke conversation utama.
                 */
                if (
                    Schema::hasTable('offers') &&
                    Schema::hasColumn(
                        'offers',
                        'conversation_id'
                    )
                ) {

                    DB::table('offers')
                        ->where(
                            'conversation_id',
                            $duplicateId
                        )
                        ->update([
                            'conversation_id' =>
                                $primary->id,
                        ]);
                }

                /*
                 * Pindahkan semua order ke conversation utama.
                 *
                 * Beberapa order boleh memiliki
                 * conversation_id yang sama.
                 */
                if (
                    Schema::hasTable('orders') &&
                    Schema::hasColumn(
                        'orders',
                        'conversation_id'
                    )
                ) {

                    DB::table('orders')
                        ->where(
                            'conversation_id',
                            $duplicateId
                        )
                        ->update([
                            'conversation_id' =>
                                $primary->id,
                        ]);
                }

                /*
                 * Kalau conversation utama belum mempunyai
                 * service, ambil service dari duplicate.
                 */
                if (
                    is_null($primary->service_id)
                ) {

                    $duplicate =
                        DB::table('conversations')
                            ->where(
                                'id',
                                $duplicateId
                            )
                            ->first();

                    if (
                        $duplicate &&
                        !is_null($duplicate->service_id)
                    ) {

                        DB::table('conversations')
                            ->where(
                                'id',
                                $primary->id
                            )
                            ->update([
                                'service_id' =>
                                    $duplicate->service_id,
                            ]);

                        $primary->service_id =
                            $duplicate->service_id;
                    }
                }

                /*
                 * Kalau conversation utama belum mempunyai
                 * Job Board context, ambil dari duplicate.
                 */
                $duplicate =
                    DB::table('conversations')
                        ->where(
                            'id',
                            $duplicateId
                        )
                        ->first();

                if ($duplicate) {

                    $updates = [];

                    if (
                        is_null($primary->job_id) &&
                        !is_null($duplicate->job_id)
                    ) {
                        $updates['job_id'] =
                            $duplicate->job_id;
                    }

                    if (
                        is_null($primary->job_proposal_id) &&
                        !is_null($duplicate->job_proposal_id)
                    ) {
                        $updates['job_proposal_id'] =
                            $duplicate->job_proposal_id;
                    }

                    if (!empty($updates)) {

                        DB::table('conversations')
                            ->where(
                                'id',
                                $primary->id
                            )
                            ->update($updates);

                        if (
                            array_key_exists(
                                'job_id',
                                $updates
                            )
                        ) {
                            $primary->job_id =
                                $updates['job_id'];
                        }

                        if (
                            array_key_exists(
                                'job_proposal_id',
                                $updates
                            )
                        ) {
                            $primary->job_proposal_id =
                                $updates['job_proposal_id'];
                        }
                    }
                }

                /*
                 * Hapus conversation duplicate
                 * setelah seluruh data dipindahkan.
                 */
                DB::table('conversations')
                    ->where(
                        'id',
                        $duplicateId
                    )
                    ->delete();
            }

            /*
             * Update waktu aktivitas conversation utama
             * berdasarkan message terbaru.
             */
            $latestMessage = null;

            if (Schema::hasTable('messages')) {

                $latestMessage =
                    DB::table('messages')
                        ->where(
                            'conversation_id',
                            $primary->id
                        )
                        ->max('created_at');
            }

            DB::table('conversations')
                ->where(
                    'id',
                    $primary->id
                )
                ->update([
                    'last_message_at' =>
                        $latestMessage
                        ?? $primary->last_message_at,
                    'updated_at' => now(),
                ]);
        }

        /*
         * Setelah duplicate dibersihkan,
         * cegah duplicate baru.
         */
        Schema::table('conversations', function (Blueprint $table) {
            $table->unique(
                [
                    'client_id',
                    'freelancer_profile_id',
                ],
                'conversations_client_freelancer_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique(
                'conversations_client_freelancer_unique'
            );
        });
    }
};
