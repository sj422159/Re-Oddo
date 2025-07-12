@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <div class="aspect-square bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white text-8xl mb-4">
                {{ $item->category->icon ?? '👕' }}
            </div>
        </div>

        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $item->title }}</h1>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Category:</span>
                        <span class="text-gray-900">{{ $item->category->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Size:</span>
                        <span class="text-gray-900">{{ strtoupper($item->size) }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Condition:</span>
                        <span class="text-gray-900">{{ ucfirst($item->condition) }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Type:</span>
                        <span class="text-gray-900">{{ ucfirst($item->type) }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-medium text-gray-900 mb-2">Description</h3>
                <p class="text-gray-700">{{ $item->description }}</p>
            </div>

            @if($item->tags)
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($item->tags as $tag)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="border-t pt-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 mr-3">
                        {{ substr($item->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $item->user->location ?? 'Location not specified' }}</p>
                    </div>
                </div>

                @auth
                    @if($item->user_id !== auth()->id() && $item->is_available)
                        <div class="space-y-4">
                            <form method="POST" action="{{ route('swaps.request') }}">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" 
                                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                                    Request Swap
                                </button>
                            </form>

                            <form method="POST" action="{{ route('swaps.redeem') }}">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" 
                                        class="w-full border-2 border-blue-600 text-blue-600 py-3 rounded-lg hover:bg-blue-50 transition font-medium"
                                        {{ auth()->user()->points < $item->point_value ? 'disabled' : '' }}>
                                    Redeem for {{ $item->point_value }} Points
                                    @if(auth()->user()->points < $item->point_value)
                                        <span class="text-red-500">(Insufficient Points)</span>
                                    @endif
                                </button>
                            </form>
                        </div>
                    @elseif($item->user_id === auth()->id())
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800">This is your item.</p>
                            <div class="mt-2 space-x-2">
                                <a href="{{ route('items.edit', $item) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-600">This item is no longer available.</p>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800 mb-2">Please log in to swap or redeem items.</p>
                        <a href="{{ route('login') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                            Log In
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
