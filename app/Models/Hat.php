<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hat extends Model
{
    use HasUuids;

    protected $fillable = ['slug', 'city', 'serial', 'user_id', 'first_scan_at', 'qr_fg_color', 'qr_bg_color', 'qr_logo_path'];

    public function claimEvents(): HasMany
    {
        return $this->hasMany(HatClaimEvent::class);
    }

    public function scans(): HasMany
    {
        return $this->hasMany(ScanEvent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
