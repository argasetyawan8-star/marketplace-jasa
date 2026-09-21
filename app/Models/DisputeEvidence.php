<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisputeEvidence extends Model
{
    protected $table = 'dispute_evidences';

    protected $fillable = [
        'dispute_id',
        'uploaded_by',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function dispute(): BelongsTo
    {
        return $this->belongsTo(
            Dispute::class,
            'dispute_id'
        );
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }
}