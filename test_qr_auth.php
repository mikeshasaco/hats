<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get a hat
$hat = App\Models\Hat::first();
if (!$hat) {
    echo "No hats found. Creating one...\n";
    $hat = App\Models\Hat::create([
        'id' => (string) \Str::uuid(),
        'slug' => \Str::random(7),
    ]);
}

echo "Testing with hat slug: " . $hat->slug . "\n";

// Test QR generation directly
$url = url("/h/{$hat->slug}");
echo "Hub URL: " . $url . "\n";

try {
    $qrController = new App\Http\Controllers\Admin\HatGenController();
    $request = new Illuminate\Http\Request();
    $request->setMethod('GET');
    
    $response = $qrController->qr($request, $hat->slug);
    $svg = $response->getContent();
    
    echo "QR SVG generated successfully!\n";
    echo "Length: " . strlen($svg) . " bytes\n";
    echo "First 200 chars: " . substr($svg, 0, 200) . "...\n";
    
    // Save to file for testing
    file_put_contents('test_qr.svg', $svg);
    echo "Saved to test_qr.svg\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "Test completed!\n";
