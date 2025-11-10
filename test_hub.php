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

echo "Testing hub page with hat slug: " . $hat->slug . "\n";

try {
    // Test the controller directly
    $controller = new App\Http\Controllers\Hub\QRController();
    $request = new Illuminate\Http\Request();
    $request->setMethod('GET');
    
    $response = $controller->show($request, $hat->slug);
    
    if ($response instanceof Illuminate\View\View) {
        echo "View created successfully!\n";
        echo "View name: " . $response->getName() . "\n";
        echo "View data: " . json_encode($response->getData()) . "\n";
    } else {
        echo "Response type: " . get_class($response) . "\n";
        echo "Response content: " . $response->getContent() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "Test completed!\n";
