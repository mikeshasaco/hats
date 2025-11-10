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
                        <h1 class="text-2xl font-bold text-gray-900">My Apps</h1>
                        <p class="text-sm text-gray-600">Access all your applications</p>
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
                    Welcome back, {{ Auth::user()->name }}!
                @else
                    Welcome to My Apps
                @endauth
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Select your city to access local applications and services. Each city has its own unique digital ecosystem.
            </p>
        </div>

        <!-- Cities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
            <!-- Philadelphia -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[4/3] bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-8 left-8 w-32 h-32 bg-white/30 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-8 right-8 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/25 rounded-full blur-lg"></div>
                    </div>
                    
                    <!-- City Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-4 gap-2 p-6 h-full">
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm shadow-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-1">Philadelphia</h3>
                            <p class="text-xs opacity-90">City of Brotherly Love</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-white/25 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                            {{ \App\Models\Hat::where('city', 'philadelphia')->count() }} Hats
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Philadelphia</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Explore Philadelphia's digital ecosystem with local apps, services, and community features.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('apps.city', 'philadelphia') }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl text-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Enter City
                        </a>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600">✓ Active</div>
                            <div class="text-xs text-gray-500">Local Services</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New York -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[4/3] bg-gradient-to-br from-yellow-400 via-orange-500 to-red-600 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-8 left-8 w-32 h-32 bg-white/30 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-8 right-8 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/25 rounded-full blur-lg"></div>
                    </div>
                    
                    <!-- City Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-4 gap-2 p-6 h-full">
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm shadow-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-1">New York</h3>
                            <p class="text-xs opacity-90">The Big Apple</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-white/25 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                            {{ \App\Models\Hat::where('city', 'new-york')->count() }} Hats
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">New York</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Discover New York's vibrant digital scene with local apps, services, and community features.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('apps.city', 'new-york') }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-yellow-500 to-red-600 text-white font-medium rounded-lg hover:from-yellow-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl text-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Enter City
                        </a>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600">✓ Active</div>
                            <div class="text-xs text-gray-500">Local Services</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Los Angeles -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[4/3] bg-gradient-to-br from-pink-400 via-purple-500 to-indigo-600 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-8 left-8 w-32 h-32 bg-white/30 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-8 right-8 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/25 rounded-full blur-lg"></div>
                    </div>
                    
                    <!-- City Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-4 gap-2 p-6 h-full">
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm shadow-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-1">Los Angeles</h3>
                            <p class="text-xs opacity-90">City of Angels</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-white/25 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                            {{ \App\Models\Hat::where('city', 'los-angeles')->count() }} Hats
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Los Angeles</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Experience LA's creative digital landscape with local apps, services, and entertainment features.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('apps.city', 'los-angeles') }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-pink-500 to-indigo-600 text-white font-medium rounded-lg hover:from-pink-600 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl text-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Enter City
                        </a>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600">✓ Active</div>
                            <div class="text-xs text-gray-500">Local Services</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chicago -->
            <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 overflow-hidden border border-gray-100">
                <div class="aspect-[4/3] bg-gradient-to-br from-green-400 via-teal-500 to-blue-600 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-8 left-8 w-32 h-32 bg-white/30 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-8 right-8 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white/25 rounded-full blur-lg"></div>
                    </div>
                    
                    <!-- City Pattern -->
                    <div class="absolute inset-0 opacity-15">
                        <div class="grid grid-cols-4 gap-2 p-6 h-full">
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                            <div class="bg-white rounded-sm h-5"></div>
                            <div class="bg-white rounded-sm h-6"></div>
                            <div class="bg-white rounded-sm h-4"></div>
                        </div>
                    </div>
                    
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="w-16 h-16 bg-white/25 rounded-2xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm shadow-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-1">Chicago</h3>
                            <p class="text-xs opacity-90">Windy City</p>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-white/25 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                            {{ \App\Models\Hat::where('city', 'chicago')->count() }} Hats
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Chicago</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Explore Chicago's innovative digital community with local apps, services, and business features.</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('apps.city', 'chicago') }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-500 to-blue-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl text-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Enter City
                        </a>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600">✓ Active</div>
                            <div class="text-xs text-gray-500">Local Services</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-12 bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 mb-1">4</div>
                    <div class="text-sm text-gray-600">Active Cities</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ \App\Models\Hat::count() }}</div>
                    <div class="text-sm text-gray-600">Total Hats</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ \App\Models\Hat::whereNotNull('user_id')->count() }}</div>
                    <div class="text-sm text-gray-600">Claimed Hats</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600 mb-1">{{ \App\Models\ScanEvent::count() }}</div>
                    <div class="text-sm text-gray-600">Total Scans</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
