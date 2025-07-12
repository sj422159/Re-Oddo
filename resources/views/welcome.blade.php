@extends('layouts.app')

@section('content')
<div class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to ReWear</h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">
            Join our community of sustainable fashion enthusiasts. Exchange, swap, and discover pre-loved clothing while reducing textile waste.
        </p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            @guest
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
                    Start Swapping
                </a>
            @else
                <a href="{{ route('items.create') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
                    List an Item
                </a>
            @endguest
            <a href="{{ route('items.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white hover:text-blue-600 transition">
                Browse Items
            </a>
        </div>
    </div>
</div>

<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Items</h2>
        
        @if($featuredItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredItems as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                        <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-6xl">
                            {{ $item->category->icon ?? '👕' }}
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($item->description, 100) }}</p>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-500">Size: {{ strtoupper($item->size) }}</span>
                                <span class="text-sm text-gray-500">{{ ucfirst($item->condition) }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('items.show', $item) }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">
                                    View Details
                                </a>
                                <button class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                    {{ $item->point_value }} pts
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-500">
                <p>No items available yet. Be the first to list an item!</p>
            </div>
        @endif
    </div>
</div>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">📸</span>
                </div>
                <h3 class="text-xl font-bold mb-2">List Your Items</h3>
                <p class="text-gray-600">Upload photos and describe clothing you no longer wear</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🔄</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Swap or Redeem</h3>
                <p class="text-gray-600">Exchange items directly or use points to redeem items you love</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🌱</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Help the Planet</h3>
                <p class="text-gray-600">Reduce textile waste and promote sustainable fashion</p>
            </div>
        </div>
    </div>
</div>
@endsection
