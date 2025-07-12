<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Swap;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_items' => Item::count(),
            'pending_items' => Item::pending()->count(),
            'total_swaps' => Swap::count(),
        ];

        $recentItems = Item::pending()->with('user')->latest()->take(5)->get();
        $recentSwaps = Swap::with(['requester', 'owner', 'item'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentItems', 'recentSwaps'));
    }

    public function pendingItems()
    {
        $items = Item::pending()->with(['user', 'category'])->latest()->paginate(10);
        return view('admin.items.pending', compact('items'));
    }

    public function approveItem(Item $item)
    {
        $item->update(['status' => 'approved']);
        
        $item->user->addPoints(25, "Item approved: {$item->title}", $item);

        return back()->with('success', 'Item approved successfully!');
    }

    public function rejectItem(Item $item)
    {
        $item->update(['status' => 'rejected']);
        return back()->with('success', 'Item rejected.');
    }

    public function users()
    {
        $users = User::withCount(['items', 'requestedSwaps'])
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function swaps()
    {
        $swaps = Swap::with(['requester', 'owner', 'item'])
            ->latest()
            ->paginate(15);

        return view('admin.swaps.index', compact('swaps'));
    }
}
