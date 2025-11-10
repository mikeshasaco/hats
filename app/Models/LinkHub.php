<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkHub extends Model
{
    protected $fillable = ['scope', 'hat_id', 'links'];

    protected $casts = [
        'links' => 'array',
    ];

    public function hat(): BelongsTo
    {
        return $this->belongsTo(Hat::class);
    }
}
