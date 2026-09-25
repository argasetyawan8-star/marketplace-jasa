<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'type',
        'attachment_path',
        'attachment_name',
        'attachment_mime',
        'attachment_size',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relasi ke conversation.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            Conversation::class
        );
    }

    /**
     * Relasi ke user pengirim pesan.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }

    /**
     * URL attachment.
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }

        return Storage::disk('public')
            ->url($this->attachment_path);
    }

    /**
     * Ukuran file yang mudah dibaca.
     */
    public function getAttachmentSizeLabelAttribute(): ?string
    {
        if (!$this->attachment_size) {
            return null;
        }

        $bytes = (int) $this->attachment_size;

        if ($bytes >= 1048576) {
            return number_format(
                $bytes / 1048576,
                1
            ) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format(
                $bytes / 1024,
                1
            ) . ' KB';
        }

        return $bytes . ' B';
    }
}