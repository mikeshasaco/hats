@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- Header Section -->
    <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst(str_replace('-', ' ', $city)) }} Apps</h1>
                        <p class="text-sm text-gray-600">Local applications for {{ ucfirst(str_replace('-', ' ', $city)) }}</p>
                    </div>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                                Sign Up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Welcome Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                @auth
                    Welcome to {{ ucfirst(str_replace('-', ' ', $city)) }}, {{ Auth::user()->name }}!
                @else
                    Welcome to {{ ucfirst(str_replace('-', ' ', $city)) }}
                @endauth
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover local applications and services available in {{ ucfirst(str_replace('-', ' ', $city)) }}. 
                Connect with your community and explore what's happening in your city.
            </p>
        </div>

        <!-- City Stats -->
        <div class="mb-12 bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ \App\Models\Hat::where('city', $city)->count() }}</div>
                    <div class="text-sm text-gray-600">Active Hats</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ \App\Models\Hat::where('city', $city)->whereNotNull('user_id')->count() }}</div>
                    <div class="text-sm text-gray-600">Claimed Hats</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ \App\Models\ScanEvent::whereHas('hat', function($q) use ($city) { $q->where('city', $city); })->count() }}</div>
                    <div class="text-sm text-gray-600">Total Scans</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600 mb-1">{{ ucfirst(str_replace('-', ' ', $city)) }}</div>
                    <div class="text-sm text-gray-600">City</div>
                </div>
            </div>
        </div>

        <!-- Apps Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">
            <!-- Hats App -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[16/10] bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-10 left-10 w-32 h-32 bg-white/30 rounded-full blur-xl"></div>
                        <div class="absolute bottom-10 right-10 w-24 h-24 bg-white/20 rounded-full blur-lg"></div>
                        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/25 rounded-full blur-md"></div>
                    </div>
                    
                    <!-- QR Code Pattern Overlay -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-6 gap-1 p-6 h-full">
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-transparent h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-transparent h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-transparent h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-transparent h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-white rounded-sm h-3"></div>
                            <div class="bg-transparent h-3"></div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-20 h-20 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm shadow-lg">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ ucfirst(str_replace('-', ' ', $city)) }} Hats</h3>
                            <p class="text-sm opacity-90">Local QR Codes</p>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6">
                        <span class="px-4 py-2 bg-white/25 backdrop-blur-sm text-white text-sm font-semibold rounded-full shadow-lg">
                            ✨ Active
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ ucfirst(str_replace('-', ' ', $city)) }} Digital Hats</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Create, manage, and track QR codes for {{ ucfirst(str_replace('-', ' ', $city)) }} digital hat collection. Monitor scans and claim ownership.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.mint.form') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-medium rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Manage Hats
                        </a>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600">✓ Live & Ready</div>
                            <div class="text-xs text-gray-500">QR Generation</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Local Services App -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[16/10] bg-gradient-to-br from-green-400 via-emerald-500 to-teal-500 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-8 left-8 w-40 h-40 bg-white/25 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-8 right-8 w-32 h-32 bg-white/20 rounded-full blur-xl"></div>
                        <div class="absolute top-1/2 left-1/4 w-20 h-20 bg-white/30 rounded-full blur-lg"></div>
                    </div>
                    
                    <!-- Restaurant Icons Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-6 gap-4 p-8 h-full">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-20 h-20 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm shadow-lg">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.1 13.34l2.83-2.83L3.91 3.5c-1.56 1.56-1.56 4.09 0 5.66l4.19 4.18zm6.78-1.81c1.53.71 3.68.21 5.27-1.38 1.91-1.91 2.28-4.65.81-6.12-1.46-1.46-4.2-1.1-6.12.81-1.59 1.59-2.09 3.74-1.38 5.27L3.7 19.87l1.41 1.41L12 14.41l6.88 6.88 1.41-1.41L13.41 13l1.47-1.47z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ ucfirst(str_replace('-', ' ', $city)) }} Services</h3>
                            <p class="text-sm opacity-90">Local Business</p>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6">
                        <span class="px-4 py-2 bg-white/25 backdrop-blur-sm text-white text-sm font-semibold rounded-full shadow-lg">
                            🚀 Coming Soon
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ ucfirst(str_replace('-', ' ', $city)) }} Local Services</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Discover restaurants, shops, and services in {{ ucfirst(str_replace('-', ' ', $city)) }}. Support local businesses and connect with your community.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <button disabled class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Coming Soon
                        </button>
                        <div class="text-right">
                            <div class="text-xs font-medium text-blue-600">🔧 In Development</div>
                            <div class="text-xs text-gray-500">Local Directory</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Main Apps -->
        <div class="mt-12 text-center">
            <a href="{{ route('apps.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to All Apps
            </a>
        </div>
    </div>
</div>
@endsection
