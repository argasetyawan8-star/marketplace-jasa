<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('job_id')
                ->nullable()
                ->after('service_id')
                ->constrained('job_posts')
                ->nullOnDelete();

            $table->foreignId('job_proposal_id')
                ->nullable()
                ->after('job_id')
                ->constrained('job_proposals')
                ->nullOnDelete();

            $table->index([
                'client_id',
                'freelancer_profile_id',
            ]);

            $table->index('job_id');
            $table->index('job_proposal_id');
        });

        /*
         * Migrasikan conversation Job Board lama
         * ke sistem Conversation utama JASAIN.
         */
        if (
            Schema::hasTable('job_conversations') &&
            Schema::hasTable('job_messages')
        ) {
            $oldConversations = DB::table('job_conversations')
                ->orderBy('id')
                ->get();

            foreach ($oldConversations as $oldConversation) {
                $existingConversation = DB::table('conversations')
                    ->where('client_id', $oldConversation->client_id)
                    ->where(
                        'freelancer_profile_id',
                        $oldConversation->freelancer_profile_id
                    )
                    ->first();

                if ($existingConversation) {
                    $newConversationId = $existingConversation->id;

                    DB::table('conversations')
                        ->where('id', $newConversationId)
                        ->update([
                            'job_id' => $oldConversation->job_id,
                            'job_proposal_id' =>
                                $oldConversation->job_proposal_id,
                            'last_message_at' =>
                                $existingConversation->last_message_at
                                ?? $oldConversation->updated_at,
                        ]);
                } else {
                    $newConversationId = DB::table('conversations')
                        ->insertGetId([
                            'client_id' => $oldConversation->client_id,
                            'freelancer_profile_id' =>
                                $oldConversation->freelancer_profile_id,
                            'service_id' => null,
                            'job_id' => $oldConversation->job_id,
                            'job_proposal_id' =>
                                $oldConversation->job_proposal_id,
                            'status' => 'active',
                            'last_message_at' =>
                                $oldConversation->updated_at,
                            'created_at' => $oldConversation->created_at,
                            'updated_at' => $oldConversation->updated_at,
                        ]);
                }

                $oldMessages = DB::table('job_messages')
                    ->where(
                        'job_conversation_id',
                        $oldConversation->id
                    )
                    ->orderBy('id')
                    ->get();

                foreach ($oldMessages as $oldMessage) {
                    $alreadyExists = DB::table('messages')
                        ->where('conversation_id', $newConversationId)
                        ->where('sender_id', $oldMessage->user_id)
                        ->where('message', $oldMessage->body)
                        ->where('created_at', $oldMessage->created_at)
                        ->exists();

                    if (!$alreadyExists) {
                        DB::table('messages')->insert([
                            'conversation_id' => $newConversationId,
                            'sender_id' => $oldMessage->user_id,
                            'message' => $oldMessage->body,
                            'type' => 'text',
                            'is_read' => $oldMessage->read_at !== null,
                            'read_at' => $oldMessage->read_at,
                            'created_at' => $oldMessage->created_at,
                            'updated_at' => $oldMessage->updated_at,
                        ]);
                    }
                }
            }

            Schema::dropIfExists('job_messages');
            Schema::dropIfExists('job_conversations');
        }
    }

    public function down(): void
    {
        /*
         * Migration rollback sengaja hanya melepas
         * kolom Job Board dari conversations.
         *
         * Data yang sudah dimigrasikan tidak dikembalikan
         * ke tabel lama secara otomatis.
         */
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropForeign(['job_proposal_id']);

            $table->dropIndex([
                'client_id',
                'freelancer_profile_id',
            ]);

            $table->dropIndex(['job_id']);
            $table->dropIndex(['job_proposal_id']);

            $table->dropColumn([
                'job_id',
                'job_proposal_id',
            ]);
        });
    }
};