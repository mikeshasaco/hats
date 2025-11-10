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

try {
    // Test the route directly
    $request = Illuminate\Http\Request::create("/h/{$hat->slug}", 'GET');
    $response = $app->handle($request);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 500) {
        echo "500 Error detected. Checking content for error details...\n";
        $content = $response->getContent();
        
        // Look for error patterns
        if (preg_match('/<div class="exception-message">(.*?)<\/div>/s', $content, $matches)) {
            echo "Exception message: " . strip_tags($matches[1]) . "\n";
        }
        
        if (preg_match('/<div class="exception-file">(.*?)<\/div>/s', $content, $matches)) {
            echo "Exception file: " . strip_tags($matches[1]) . "\n";
        }
        
        // Save the full response to a file for inspection
        file_put_contents('error_response.html', $content);
        echo "Full error response saved to error_response.html\n";
    }
    
} catch (Exception $e) {
    echo "Exception caught: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "Test completed!\n";
