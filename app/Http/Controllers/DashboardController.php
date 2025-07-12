<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Swap;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        $userItems = $user->items()->with('category')->latest()->get();
        
        $receivedSwapRequests = $user->receivedSwaps()
            ->with(['requester', 'item', 'offeredItem'])
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        $sentSwapRequests = $user->requestedSwaps()
            ->with(['owner', 'item', 'offeredItem'])
            ->latest()
            ->take(5)
            ->get();
            
        $recentTransactions = $user->pointTransactions()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'userItems',
            'receivedSwapRequests',
            'sentSwapRequests',
            'recentTransactions'
        ));
        
    }
}
