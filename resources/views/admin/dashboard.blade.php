@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600">Manage the ReWear platform</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <span class="text-2xl">👕</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Items</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_items'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <span class="text-2xl">⏳</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Items</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_items'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <span class="text-2xl">🔄</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Swaps</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_swaps'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Recent Pending Items</h2>
                    <a href="{{ route('admin.items.pending') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentItems->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentItems as $item)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white">
                                        {{ $item->category->icon ?? '👕' }}
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-medium text-gray-900">{{ $item->title }}</h3>
                                        <p class="text-sm text-gray-600">by {{ $item->user->name }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('admin.items.approve', $item) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.items.reject', $item) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No pending items.</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Recent Swaps</h2>
                    <a href="{{ route('admin.swaps') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentSwaps->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSwaps as $swap)
                            <div class="border-b border-gray-100 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $swap->item->title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $swap->requester->name }} → {{ $swap->owner->name }}
                                        </p>
                                    </div>
                                    <span class="text-xs bg-{{ $swap->status === 'completed' ? 'green' : ($swap->status === 'accepted' ? 'blue' : 'yellow') }}-100 
                                               text-{{ $swap->status === 'completed' ? 'green' : ($swap->status === 'accepted' ? 'blue' : 'yellow') }}-800 
                                               px-2 py-1 rounded">
                                        {{ ucfirst($swap->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $swap->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No recent swaps.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
