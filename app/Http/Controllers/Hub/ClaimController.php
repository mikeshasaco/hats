<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Hat;
use App\Models\HatClaimEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function claim(Request $req, string $slug)
    {
        $uid = $req->user()->id;

        $claimedHat = DB::transaction(function () use ($slug, $uid, $req) {
            $hat = Hat::where('slug', $slug)->lockForUpdate()->firstOrFail();
            if ($hat->user_id) {
                return null; // already claimed
            }
            $hat->user_id = $uid;
            $hat->first_scan_at = now();
            $hat->save();

            HatClaimEvent::create([
                'id' => (string) \Str::uuid(),
                'hat_id' => $hat->id,
                'user_id' => $uid,
                'ip' => $req->ip(),
                'user_agent' => $req->userAgent(),
            ]);

            return $hat;
        });

        if (!$claimedHat) {
            return back()->withErrors(['claim' => 'Already claimed.']);
        }
        
        return redirect()->route('hub.show', ['slug' => $slug])
            ->with('ok', 'Hat claimed to your account.');
    }
}
