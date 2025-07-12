@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h1>
        <p class="text-gray-600">Manage your items, track swaps, and earn points.</p>
    </div>

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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="text-2xl">👕</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Items Listed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->items_listed_count }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <span class="text-2xl">🔄</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Swaps Made</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->swaps_made_count }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <span class="text-2xl">⭐</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Points</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->points }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <span class="text-2xl">📬</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $receivedSwapRequests->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Your Items</h2>
                    <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Add New Item
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($userItems->count() > 0)
                    <div class="space-y-4">
                        @foreach($userItems->take(5) as $item)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white">
                                        {{ $item->category->icon ?? '👕' }}
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-medium text-gray-900">{{ $item->title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            Status: 
                                            @if($item->status === 'approved')
                                                @if($item->is_available)
                                                    <span class="text-green-600">Available</span>
                                                @else
                                                    <span class="text-gray-600">Swapped</span>
                                                @endif
                                            @elseif($item->status === 'pending')
                                                <span class="text-yellow-600">Pending Approval</span>
                                            @else
                                                <span class="text-red-600">Rejected</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                    @if($item->status === 'approved' && $item->is_available)
                                        <a href="{{ route('items.edit', $item) }}" class="text-gray-600 hover:text-gray-800">Edit</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">You haven't listed any items yet.</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Swap Requests</h2>
            </div>
            <div class="p-6">
                @if($receivedSwapRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($receivedSwapRequests as $swap)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $swap->requester->name }}</h3>
                                        <p class="text-sm text-gray-600">wants to swap for "{{ $swap->item->title }}"</p>
                                    </div>
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">{{ ucfirst($swap->type) }}</span>
                                </div>
                                
                                @if($swap->offeredItem)
                                    <p class="text-sm text-gray-600 mb-3">Offering: {{ $swap->offeredItem->title }}</p>
                                @elseif($swap->points_used)
                                    <p class="text-sm text-gray-600 mb-3">Points: {{ $swap->points_used }}</p>
                                @endif

                                @if($swap->message)
                                    <p class="text-sm text-gray-600 mb-3">"{{ $swap->message }}"</p>
                                @endif

                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('swaps.accept', $swap) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('swaps.decline', $swap) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No pending swap requests.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
