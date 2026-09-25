<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            /*
             * Lokasi file yang diupload.
             */
            if (!Schema::hasColumn('messages', 'attachment_path')) {
                $table->string('attachment_path')
                    ->nullable()
                    ->after('message');
            }

            /*
             * Nama file asli.
             */
            if (!Schema::hasColumn('messages', 'attachment_name')) {
                $table->string('attachment_name')
                    ->nullable()
                    ->after('attachment_path');
            }

            /*
             * MIME type file.
             *
             * Contoh:
             * image/jpeg
             * image/png
             * application/pdf
             * audio/webm
             * audio/wav
             */
            if (!Schema::hasColumn('messages', 'attachment_mime')) {
                $table->string('attachment_mime')
                    ->nullable()
                    ->after('attachment_name');
            }

            /*
             * Ukuran file dalam byte.
             */
            if (!Schema::hasColumn('messages', 'attachment_size')) {
                $table->unsignedBigInteger('attachment_size')
                    ->nullable()
                    ->after('attachment_mime');
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            if (Schema::hasColumn('messages', 'attachment_size')) {
                $table->dropColumn('attachment_size');
            }

            if (Schema::hasColumn('messages', 'attachment_mime')) {
                $table->dropColumn('attachment_mime');
            }

            if (Schema::hasColumn('messages', 'attachment_name')) {
                $table->dropColumn('attachment_name');
            }

            if (Schema::hasColumn('messages', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
        });
    }
};
