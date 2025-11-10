<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Hat;
use App\Models\ScanEvent;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function show(Request $req, string $slug)
    {
        $hat = Hat::where('slug', $slug)->firstOrFail();
        
        // log scan
        ScanEvent::create([
            'id' => (string) \Str::uuid(),
            'hat_id' => $hat->id,
            'user_id' => optional($req->user())->id,
            'ip' => $req->ip(),
            'user_agent' => $req->userAgent(),
        ]);

        // very simple "Link Hub"
        // If owner exists -> show hub; otherwise show claim CTA + sign-in prompt
        return view('hub.show', ['hat' => $hat]);
    }
}
