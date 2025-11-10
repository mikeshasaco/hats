<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create a test user if not exists
$user = App\Models\User::firstOrCreate(
    ['email' => 'test@example.com'],
    ['name' => 'Test User', 'password' => bcrypt('password')]
);

// Test creating a hat
$hat = App\Models\Hat::create([
    'id' => (string) \Str::uuid(),
    'slug' => \Str::random(7),
]);

echo "Created hat with slug: " . $hat->slug . "\n";

// Test QR generation
$url = url("/h/{$hat->slug}");
echo "Hub URL: " . $url . "\n";

// Test QR SVG generation
$qrController = new App\Http\Controllers\Admin\HatGenController();
$request = new Illuminate\Http\Request();
$request->setMethod('GET');

try {
    $response = $qrController->qr($request, $hat->slug);
    $svg = $response->getContent();
    echo "QR SVG generated successfully (length: " . strlen($svg) . " bytes)\n";
    echo "First 100 chars: " . substr($svg, 0, 100) . "...\n";
} catch (Exception $e) {
    echo "Error generating QR: " . $e->getMessage() . "\n";
}

echo "Test completed successfully!\n";
