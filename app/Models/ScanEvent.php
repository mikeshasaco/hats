<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanEvent extends Model
{
    use HasUuids;

    protected $fillable = ['hat_id', 'user_id', 'ip', 'user_agent', 'occurred_at'];

    public function hat(): BelongsTo
    {
        return $this->belongsTo(Hat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
