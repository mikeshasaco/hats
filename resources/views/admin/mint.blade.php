@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <!-- Header Section -->
    <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Hat Minting Studio</h1>
                        <p class="text-gray-600">Create and manage digital hats with QR codes</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('apps.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Apps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Message -->
        @if(session('ok'))
        <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('ok') }}</span>
            </div>
        </div>
        @endif

        <!-- Mint Form Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white mb-2">Create New Hats</h2>
                <p class="text-blue-100">Generate digital hats with city-specific QR codes</p>
            </div>
            
            <div class="p-8">
                <form method="POST" action="{{ route('admin.mint') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Number of Hats</label>
                            <div class="relative">
                                <input name="count" type="number" value="5" min="1" max="50" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Choose how many hats to create (1-50)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">City Assignment</label>
                            <div class="relative">
                                <select name="city" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm appearance-none bg-white">
                                    <option value="philadelphia">🏛️ Philadelphia</option>
                                    <option value="new-york">🗽 New York</option>
                                    <option value="los-angeles">🌴 Los Angeles</option>
                                    <option value="chicago">🏙️ Chicago</option>
                                    <option value="miami">🏖️ Miami</option>
                                    <option value="boston">🎓 Boston</option>
                                    <option value="seattle">☕ Seattle</option>
                                    <option value="denver">🏔️ Denver</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">QR codes will link to this city's app page</p>
                        </div>
                    </div>
                    
                    <!-- QR Code Customization Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <button type="button" id="qrCustomizeToggle" class="flex items-center justify-between w-full text-left">
                            <span class="text-sm font-semibold text-gray-700">QR Code Customization (Optional)</span>
                            <svg id="qrToggleIcon" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div id="qrCustomizeSection" class="hidden mt-4 space-y-4 bg-gray-50 rounded-xl p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foreground Color</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="color" id="mintFgColor" name="fg_color" value="#000000" 
                                               class="w-16 h-10 rounded-lg border border-gray-300 cursor-pointer">
                                        <input type="text" id="mintFgColorText" value="#000000" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Color of QR code dots (saved to hat)</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Background Color</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="color" id="mintBgColor" name="bg_color" value="#FFFFFF" 
                                               class="w-16 h-10 rounded-lg border border-gray-300 cursor-pointer">
                                        <input type="text" id="mintBgColorText" value="#FFFFFF" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Background color (saved to hat)</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo (optional)</label>
                                <input type="file" name="logo" accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <p class="text-xs text-gray-500 mt-1">Add a logo in the center of the QR code (saved to hat)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">QR Link:</span> Codes link to hat hub 
                            <code class="bg-gray-100 px-2 py-1 rounded text-xs">/h/{slug}</code>
                        </div>
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Mint Hats
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- QR Code Generator Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-12">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white mb-2">QR Code Generator</h2>
                        <p class="text-purple-100">Override QR colors for individual hat views (colors are saved when minting)</p>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Color Settings</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foreground Color</label>
                            <input type="color" id="qrFgColor" value="#000000" class="w-full h-12 rounded-lg cursor-pointer">
                            <input type="text" id="qrFgColorText" value="#000000" placeholder="#000000" 
                                   class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <input type="color" id="qrBgColor" value="#FFFFFF" class="w-full h-12 rounded-lg cursor-pointer">
                            <input type="text" id="qrBgColorText" value="#FFFFFF" placeholder="#FFFFFF" 
                                   class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div class="pt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Example URLs:</h4>
                            <code class="block bg-gray-100 p-3 rounded text-xs break-all" id="qrExampleUrl">
                                /admin/qr/YOUR_SLUG.svg?fg_color=#000000&bg_color=#FFFFFF
                            </code>
                            <p class="text-xs text-gray-500 mt-2">Copy this URL and replace YOUR_SLUG with a hat slug</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Preview</h3>
                        <div class="bg-gray-50 rounded-lg p-6 flex items-center justify-center min-h-[300px] border-2 border-dashed border-gray-300">
                            <p class="text-gray-400 text-center">
                                Select a hat below to preview<br/>
                                a customized QR code
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Existing Hats Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Existing Hats</h2>
                        <p class="text-gray-200">Manage and view your created digital hats</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-white">{{ \App\Models\Hat::count() }}</div>
                        <div class="text-sm text-gray-200">Total Hats</div>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                @if(\App\Models\Hat::count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(\App\Models\Hat::latest()->take(12)->get() as $hat)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $hat->slug }}</h3>
                                <div class="flex items-center space-x-2">
                                    @if($hat->city)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ ucfirst(str_replace('-', ' ', $hat->city)) }}
                                    </span>
                                    @endif
                                    @if($hat->user_id)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        Claimed
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Available
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">QR Code:</span>
                                    <a target="_blank" href="{{ route('admin.qr', ['slug' => $hat->slug, 'ext' => 'svg']) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-medium rounded-lg hover:from-blue-600 hover:to-purple-600 transition-all shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                        </svg>
                                        View QR
                                    </a>
                                </div>
                                
                                <div class="bg-gray-100 rounded-lg p-2">
                                    <button onclick="customizeQR('{{ $hat->slug }}')" class="w-full text-xs text-gray-600 hover:text-blue-600">
                                        Customize QR Colors
                                    </button>
                                    <div id="qr-custom-{{ $hat->slug }}" class="hidden mt-2 text-xs text-gray-500">
                                        Use query parameters: ?fg_color=#000000&bg_color=#FFFFFF
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">City App:</span>
                                <a target="_blank" href="{{ url('/app/'.($hat->city ?? 'philadelphia')) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white text-xs font-medium rounded-lg hover:from-green-600 hover:to-teal-600 transition-all shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    Visit
                                </a>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Created:</span>
                                <span class="text-xs text-gray-500">{{ $hat->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(\App\Models\Hat::count() > 12)
                <div class="mt-8 text-center">
                    <p class="text-gray-600">Showing latest 12 hats. Total: {{ \App\Models\Hat::count() }} hats</p>
                </div>
                @endif
                
                @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hats created yet</h3>
                    <p class="text-gray-600 mb-6">Create your first digital hat using the form above</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle QR customization section
    document.getElementById('qrCustomizeToggle')?.addEventListener('click', function() {
        const section = document.getElementById('qrCustomizeSection');
        const icon = document.getElementById('qrToggleIcon');
        
        section.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
    
    // QR Generator Section Color Sync
    function syncQRGeneratorColors() {
        const fgColor = document.getElementById('qrFgColor');
        const fgColorText = document.getElementById('qrFgColorText');
        const bgColor = document.getElementById('qrBgColor');
        const bgColorText = document.getElementById('qrBgColorText');
        const exampleUrl = document.getElementById('qrExampleUrl');
        
        // Sync foreground color
        if (fgColor && fgColorText) {
            fgColor.addEventListener('change', function() {
                fgColorText.value = this.value;
                updateExampleUrl();
            });
            
            fgColorText.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    fgColor.value = this.value;
                    updateExampleUrl();
                }
            });
        }
        
        // Sync background color
        if (bgColor && bgColorText) {
            bgColor.addEventListener('change', function() {
                bgColorText.value = this.value;
                updateExampleUrl();
            });
            
            bgColorText.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    bgColor.value = this.value;
                    updateExampleUrl();
                }
            });
        }
        
        function updateExampleUrl() {
            if (exampleUrl) {
                exampleUrl.textContent = `/admin/qr/YOUR_SLUG.svg?fg_color=${encodeURIComponent(fgColor.value)}&bg_color=${encodeURIComponent(bgColor.value)}`;
            }
        }
        
        updateExampleUrl();
    }
    
    // Initialize QR generator color sync
    syncQRGeneratorColors();
    
    // Sync color picker with text input in mint form
    const mintFgColor = document.getElementById('mintFgColor');
    const mintFgColorText = document.getElementById('mintFgColorText');
    const mintBgColor = document.getElementById('mintBgColor');
    const mintBgColorText = document.getElementById('mintBgColorText');
    
    if (mintFgColor && mintFgColorText) {
        mintFgColor.addEventListener('change', function() {
            mintFgColorText.value = this.value;
        });
        mintFgColorText.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                mintFgColor.value = this.value;
            }
        });
        mintFgColorText.addEventListener('blur', function() {
            // Sync back on blur to ensure consistency
            mintFgColor.value = this.value || '#000000';
        });
    }
    
    if (mintBgColor && mintBgColorText) {
        mintBgColor.addEventListener('change', function() {
            mintBgColorText.value = this.value;
        });
        mintBgColorText.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                mintBgColor.value = this.value;
            }
        });
        mintBgColorText.addEventListener('blur', function() {
            // Sync back on blur to ensure consistency
            mintBgColor.value = this.value || '#FFFFFF';
        });
    }
    
    function customizeQR(slug) {
        const customDiv = document.getElementById('qr-custom-' + slug);
        if (customDiv) {
            customDiv.classList.toggle('hidden');
            
            // Get current colors from QR generator
            const fgColor = document.getElementById('qrFgColor')?.value || '#000000';
            const bgColor = document.getElementById('qrBgColor')?.value || '#FFFFFF';
            
            // Update QR link with colors
            const qrLink = customDiv.parentElement.querySelector('a[href*="admin.qr"]');
            if (qrLink) {
                const baseUrl = qrLink.href.split('?')[0];
                qrLink.href = `${baseUrl}?fg_color=${encodeURIComponent(fgColor)}&bg_color=${encodeURIComponent(bgColor)}`;
                
                // Update the custom QR URL text
                customDiv.innerHTML = `
                    <div class="space-y-2 mt-2">
                        <div class="text-xs font-medium text-gray-700">Customized URL:</div>
                        <code class="block bg-gray-100 p-2 rounded text-xs break-all">
                            ${baseUrl}?fg_color=${encodeURIComponent(fgColor)}&bg_color=${encodeURIComponent(bgColor)}
                        </code>
                        <a href="${baseUrl}?fg_color=${encodeURIComponent(fgColor)}&bg_color=${encodeURIComponent(bgColor)}" 
                           target="_blank" class="text-xs text-blue-600 hover:underline block">
                            View Custom QR →
                        </a>
                    </div>
                `;
                customDiv.classList.remove('hidden');
            }
        }
    }
</script>
@endpush
@endsection
