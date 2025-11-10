<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test if the route is working
$hat = App\Models\Hat::first();
if (!$hat) {
    $hat = App\Models\Hat::create([
        'id' => (string) \Str::uuid(),
        'slug' => \Str::random(7),
    ]);
}

echo "Testing route: /h/{$hat->slug}\n";

// Test the route directly
$request = Illuminate\Http\Request::create("/h/{$hat->slug}", 'GET');
$response = $app->handle($request);

echo "Response status: " . $response->getStatusCode() . "\n";
echo "Response content type: " . $response->headers->get('Content-Type') . "\n";
echo "Response content length: " . strlen($response->getContent()) . "\n";

// Check if it contains our expected content
$content = $response->getContent();
if (strpos($content, 'Hat:') !== false) {
    echo "✓ Hub page content found!\n";
} else {
    echo "✗ Hub page content NOT found\n";
    echo "First 200 chars: " . substr($content, 0, 200) . "...\n";
}

echo "Test completed!\n";
