<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hat;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;

class HatGenController extends Controller
{
    public function form()
    {
        return view('admin.mint');
    }

    public function mint(Request $r)
    {
        $count = max(1, (int) $r->input('count', 5));
        $city = $r->input('city', 'philadelphia'); // Default to philadelphia
        
        // Get QR customization settings from form
        $fgColor = $r->input('fg_color', '#000000');
        $bgColor = $r->input('bg_color', '#FFFFFF');
        $modulePattern = $r->input('module_pattern', 'margin');
        $websiteUrl = $r->input('website_url', null);
        
        // Validate URL if provided
        if ($websiteUrl && !filter_var($websiteUrl, FILTER_VALIDATE_URL)) {
            return back()->withErrors(['website_url' => 'Please enter a valid URL (e.g., https://example.com)']);
        }
        
        // Handle logo upload if provided
        $logoPath = null;
        if ($r->hasFile('logo')) {
            $file = $r->file('logo');
            $filename = 'qr-logo-' . time() . '.png'; // Always save as PNG for transparency
            $storedPath = $file->storeAs('qr-logos', $filename, 'public');
            
            // Process logo to make it circular
            $fullPath = storage_path('app/public/' . $storedPath);
            $this->makeLogoCircular($fullPath);
            
            // Store the public-accessible path
            $logoPath = '/storage/' . $storedPath;
        }
        
        for ($i = 0; $i < $count; $i++) {
            \App\Models\Hat::create([
                'id' => (string) \Str::uuid(),
                'slug' => \Str::random(7),
                'city' => $city,
                'qr_fg_color' => $fgColor,
                'qr_bg_color' => $bgColor,
                'qr_logo_path' => $logoPath, // Already includes /storage/ prefix
                'qr_module_pattern' => $modulePattern, // Module pattern/style
                'website_url' => $websiteUrl, // Website URL for QR code redirect
            ]);
        }
        
        $message = "Minted $count hats for {$city}.";
        if ($websiteUrl) {
            $message .= " QR codes will redirect to: {$websiteUrl}.";
        }
        if ($logoPath) {
            $message .= " QR codes will include the uploaded logo by default.";
        }
        if ($fgColor !== '#000000' || $bgColor !== '#FFFFFF') {
            $message .= " Custom colors saved: fg={$fgColor}, bg={$bgColor}.";
        }
        
        return back()->with('ok', $message);
    }

    public function qr(Request $r, string $slug, string $ext = 'svg')
    {
        $hat = Hat::where('slug', $slug)->firstOrFail();
        
        // Use website URL if set, otherwise link to the hat's hub
        $url = $hat->website_url ?: url("/h/{$slug}");
        
        // Configuration from request parameters (override saved values)
        // Also accept alternate keys without underscores in case links omit encoding of '#'
        // Use saved hat values as defaults, falling back to standard defaults
        $fgColor = $r->input('fg_color', $r->input('fg', $hat->qr_fg_color ?? '#000000'));
        $bgColor = $r->input('bg_color', $r->input('bg', $hat->qr_bg_color ?? '#FFFFFF'));
        
        // Logo handling: use query param if provided, otherwise use saved logo_path
        $showLogo = $r->input('show_logo', false);
        $logoPath = $r->input('logo_path', '');
        
        // If no logo_path in query but hat has saved logo, use it
        if (empty($logoPath) && !empty($hat->qr_logo_path)) {
            $logoPath = $hat->qr_logo_path;
            $showLogo = true; // Auto-show if hat has saved logo
        }
        
        // QR size (allow overriding) - larger size = modules more spread out (less grouped)
        // For hats, we want larger modules that are easier to scan from distance
        $qrSize = (int) $r->input('size', 1500); // Larger size for hat scanning - modules more spread out
        
        // Parse colors (required by QR code library)
        // Use the actual foreground and background colors from the request
        $foregroundColor = $this->parseColor($fgColor); // Foreground color for modules
        $backgroundColor = $this->parseColor($bgColor); // Background color
        
        // Determine error correction level
        // For minimal modules, use Low error correction when no logo
        // When logo is present, we need High for punchout to work
        $errorCorrection = $r->input('error_correction', '');
        if (empty($errorCorrection)) {
            // Default: Low if no logo (fewest modules), High if logo present (needed for punchout)
            $errorCorrection = ($showLogo && !empty($logoPath)) ? 'H' : 'L';
        }
        
        $errorLevel = match(strtoupper($errorCorrection)) {
            'L' => ErrorCorrectionLevel::Low,      // 7% - fewest modules, least redundancy
            'M' => ErrorCorrectionLevel::Medium,    // 15% - balanced
            'Q' => ErrorCorrectionLevel::Quartile, // 25% - more modules
            'H' => ErrorCorrectionLevel::High,     // 30% - most modules, most redundancy (needed for logo)
            default => ($showLogo && !empty($logoPath)) ? ErrorCorrectionLevel::High : ErrorCorrectionLevel::Low
        };
        
        // Use PNG writer if logo with punchout is needed (SVG doesn't support punchout)
        // Otherwise use SVG for scalability
        $usePngForPunchout = $showLogo && !empty($logoPath);
        $writer = $usePngForPunchout ? new PngWriter() : new SvgWriter();
        
        // Prepare logo settings
        $logoFullPath = null;
        $logoWidth = null;
        $logoPunchout = false;
        
        // Add logo if requested
        if ($showLogo && !empty($logoPath)) {
            // Try multiple path variations to find the logo file
            $possiblePaths = [
                public_path($logoPath), // Direct public path
                public_path(ltrim($logoPath, '/')), // Without leading slash
                storage_path('app/public/' . str_replace('/storage/', '', $logoPath)), // Storage path
            ];
            
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $logoFullPath = $path;
                    break;
                }
            }
            
            if ($logoFullPath) {
                // Logo size: ~25% of QR size - smaller logo = fewer modules need to be removed
                // Use High error correction when logo is present to ensure enough redundancy
                $defaultLogoWidth = max(100, (int) round($qrSize * 0.25));
                $logoWidth = (int) $r->input('logo_width', $defaultLogoWidth);
                
                // Add circular border around logo and create padded version
                // The border ensures no modules can get inside the circle
                // Pass foreground and background colors so corners match foreground and circle matches background
                $logoWithBorder = $this->addCircularBorderToLogo($logoFullPath, $logoWidth, $foregroundColor, $backgroundColor);
                $logoFullPath = $logoWithBorder;
                
                // Make punchout area SIGNIFICANTLY larger to ensure NO white circular modules touch the circle
                // Increase punchout area by 40% to create a larger clear zone - ensures modules stay OUTSIDE circle
                // This prevents any white circular modules from touching or appearing inside the black circle border
                $punchoutSize = (int) round($logoWidth * 1.40); // 40% larger to ensure complete clearance, no modules inside
                $logoWidth = $punchoutSize;
                
                // Force High error correction when logo is present to ensure scannability
                // High error correction provides more redundancy so removing center modules is safe
                if ($errorLevel !== ErrorCorrectionLevel::High) {
                    $errorLevel = ErrorCorrectionLevel::High;
                }
                
                // Enable punchout - removes ALL modules behind logo
                $logoPunchout = true;
            }
        }
        
        // Determine module pattern/style
        // Options: 'none' (square), 'margin' (rounded/circular), 'enlarge' (larger rounded), 'shrink' (smaller rounded)
        // Use saved pattern from hat, allow override via query parameter
        $modulePattern = $r->input('module_pattern', $hat->qr_module_pattern ?? 'margin');
        $roundBlockSizeMode = match(strtolower($modulePattern)) {
            'none' => RoundBlockSizeMode::None,      // Square modules (standard QR code)
            'enlarge' => RoundBlockSizeMode::Enlarge, // Larger rounded modules
            'shrink' => RoundBlockSizeMode::Shrink,   // Smaller rounded modules
            'margin' => RoundBlockSizeMode::Margin,    // Rounded/circular modules (default)
            default => RoundBlockSizeMode::Margin
        };
        
        // Create Builder with v6 API (constructor-based)
        $builder = new Builder(
            writer: $writer,
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: $errorLevel,
            size: $qrSize,
            margin: 4,
            roundBlockSizeMode: $roundBlockSizeMode, // Module pattern/style
            foregroundColor: $foregroundColor,
            backgroundColor: $backgroundColor,
            logoPath: $logoFullPath ?? '',
            logoResizeToWidth: $logoWidth,
            logoPunchoutBackground: $logoPunchout // Removes modules inside circle
        );
        
        // Build the QR code
        $result = $builder->build();
        
        // Return the appropriate format
        $imageData = $result->getString();
        $contentType = $usePngForPunchout ? 'image/png' : 'image/svg+xml';
        return response($imageData)->header('Content-Type', $contentType);
    }
    
    private function parseColor(string $color): Color
    {
        // Normalize and support multiple formats
        $trimmed = trim($color);
        
        // rgb(r,g,b)
        if (preg_match('/^rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/i', $trimmed, $m)) {
            $r = max(0, min(255, (int) $m[1]));
            $g = max(0, min(255, (int) $m[2]));
            $b = max(0, min(255, (int) $m[3]));
            return new Color($r, $g, $b);
        }
        
        // #RRGGBB or RRGGBB
        $hex = ltrim($trimmed, '#');
        if (strlen($hex) === 6 && ctype_xdigit($hex)) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            return new Color($r, $g, $b);
        }
        
        // #RGB or RGB
        if (strlen($hex) === 3 && ctype_xdigit($hex)) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
            return new Color($r, $g, $b);
        }
        
        // Default to black
        return new Color(0, 0, 0);
    }
    
    /**
     * Process uploaded logo to make it circular with transparent background
     */
    private function makeLogoCircular(string $imagePath): void
    {
        if (!function_exists('imagecreatefromjpeg')) {
            return; // GD not available, skip processing
        }
        
        // Get image info
        $imageInfo = @getimagesize($imagePath);
        if (!$imageInfo) {
            return;
        }
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Create source image based on type
        $source = null;
        switch ($mimeType) {
            case 'image/jpeg':
                $source = @imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $source = @imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $source = @imagecreatefromgif($imagePath);
                break;
            default:
                return; // Unsupported format
        }
        
        if (!$source) {
            return;
        }
        
        // Use the smaller dimension to ensure it's a perfect circle
        $size = min($width, $height);
        $radius = $size / 2;
        
        // Create a square transparent image
        $circular = imagecreatetruecolor($size, $size);
        imagealphablending($circular, false);
        imagesavealpha($circular, true);
        
        // Fill with transparent background
        $transparent = imagecolorallocatealpha($circular, 0, 0, 0, 127);
        imagefill($circular, 0, 0, $transparent);
        
        // Calculate center and crop source to square if needed
        $sourceX = max(0, ($width - $size) / 2);
        $sourceY = max(0, ($height - $size) / 2);
        
        // Copy and resize source to square
        $square = imagecreatetruecolor($size, $size);
        imagealphablending($square, false);
        imagesavealpha($square, true);
        $transparentSquare = imagecolorallocatealpha($square, 0, 0, 0, 127);
        imagefill($square, 0, 0, $transparentSquare);
        
        imagecopyresampled($square, $source, 0, 0, $sourceX, $sourceY, $size, $size, $size, $size);
        
        // Create circular mask using distance from center
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $dx = $x - $radius;
                $dy = $y - $radius;
                $distance = sqrt($dx * $dx + $dy * $dy);
                
                if ($distance <= $radius) {
                    $pixel = imagecolorat($square, $x, $y);
                    imagesetpixel($circular, $x, $y, $pixel);
                }
            }
        }
        
        // Save as PNG with transparency
        imagepng($circular, $imagePath, 9);
        
        // Clean up
        imagedestroy($source);
        imagedestroy($square);
        imagedestroy($circular);
    }
    
    /**
     * Add a circular border around the logo to create a clear zone
     * This ensures no QR code modules can appear inside the circle
     * Corners outside the circle will match the foreground color
     * Circle behind logo will match the background color
     */
    private function addCircularBorderToLogo(string $logoPath, int $targetWidth, Color $foregroundColor, Color $backgroundColor): string
    {
        if (!function_exists('imagecreatefrompng')) {
            return $logoPath; // GD not available, return original
        }
        
        // Create a temporary path for the logo with white background
        $borderLogoPath = str_replace('.png', '_bordered.png', $logoPath);
        
        // Load the circular logo
        $logo = @imagecreatefrompng($logoPath);
        if (!$logo) {
            return $logoPath; // Can't load, return original
        }
        
        $logoSize = imagesx($logo); // Should be square after circular processing
        
        // Use the logo size as the base, but ensure it matches targetWidth for punchout
        // The white circle should fit the logo perfectly without cutting it off
        $newSize = max($logoSize, $targetWidth); // Use larger of the two to ensure logo fits
        
        $bordered = imagecreatetruecolor($newSize, $newSize);
        
        // Fill entire image with foreground color first (corners will match foreground)
        // Get RGB values from foreground color
        $fgR = $foregroundColor->getRed();
        $fgG = $foregroundColor->getGreen();
        $fgB = $foregroundColor->getBlue();
        
        $foregroundColorGD = imagecolorallocate($bordered, $fgR, $fgG, $fgB);
        imagefill($bordered, 0, 0, $foregroundColorGD); // Fill entire square with foreground color
        
        // Draw a circular background matching the QR background color - circle fits the logo size perfectly
        // Use logoSize as the circle diameter to ensure logo fits without cutting
        $centerX = $newSize / 2;
        $centerY = $newSize / 2;
        $radius = $logoSize / 2; // Use logo size for radius so it fits perfectly
        
        // Fill the circle with background color (matches QR code background)
        $bgR = $backgroundColor->getRed();
        $bgG = $backgroundColor->getGreen();
        $bgB = $backgroundColor->getBlue();
        $circleBackground = imagecolorallocate($bordered, $bgR, $bgG, $bgB);
        imagealphablending($bordered, false); // Disable blending for solid fill
        imagefilledellipse($bordered, $centerX, $centerY, $radius * 2, $radius * 2, $circleBackground);
        
        // Center the logo on the circular background
        $logoX = ($newSize - $logoSize) / 2;
        $logoY = ($newSize - $logoSize) / 2;
        
        // Copy logo on top of circular background
        imagealphablending($bordered, true); // Enable blending for logo overlay
        imagecopy($bordered, $logo, $logoX, $logoY, 0, 0, $logoSize, $logoSize);
        
        // Save the logo with circular background matching QR background color
        // Corners are filled with foreground color (no transparency needed)
        imagealphablending($bordered, false);
        imagesavealpha($bordered, false); // No alpha - solid colors
        imagepng($bordered, $borderLogoPath, 9);
        
        // Clean up
        imagedestroy($logo);
        imagedestroy($bordered);
        
        return $borderLogoPath;
    }
}
