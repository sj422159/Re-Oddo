@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Browse Items</h1>
        
        <form method="GET" action="{{ route('items.index') }}" class="bg-white p-6 rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search items..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                    <select name="size" id="size" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Sizes</option>
                        <option value="xs" {{ request('size') === 'xs' ? 'selected' : '' }}>XS</option>
                        <option value="s" {{ request('size') === 's' ? 'selected' : '' }}>S</option>
                        <option value="m" {{ request('size') === 'm' ? 'selected' : '' }}>M</option>
                        <option value="l" {{ request('size') === 'l' ? 'selected' : '' }}>L</option>
                        <option value="xl" {{ request('size') === 'xl' ? 'selected' : '' }}>XL</option>
                        <option value="xxl" {{ request('size') === 'xxl' ? 'selected' : '' }}>XXL</option>
                    </select>
                </div>
                
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                    <select name="condition" id="condition" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') === 'new' ? 'selected' : '' }}>New with tags</option>
                        <option value="excellent" {{ request('condition') === 'excellent' ? 'selected' : '' }}>Excellent</option>
                        <option value="good" {{ request('condition') === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ request('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4 flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Apply Filters
                </button>
                <a href="{{ route('items.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    @if($items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($items as $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl">
                        {{ $item->category->icon ?? '👕' }}
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                            <span>Size: {{ strtoupper($item->size) }}</span>
                            <span>{{ ucfirst($item->condition) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>by {{ $item->user->name }}</span>
                            <span class="font-bold text-blue-600">{{ $item->point_value }} pts</span>
                        </div>
                        
                        <a href="{{ route('items.show', $item) }}" 
                           class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $items->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">👕</div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No items found</h3>
            <p class="text-gray-600 mb-4">Try adjusting your search criteria or browse all items.</p>
            <a href="{{ route('items.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                View All Items
            </a>
        </div>
    @endif
</div>
@endsection
