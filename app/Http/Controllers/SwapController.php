<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Swap;
use Illuminate\Http\Request;

class SwapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function request(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'offered_item_id' => 'nullable|exists:items,id',
            'message' => 'nullable|string|max:500',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->user_id === auth()->id()) {
            return back()->with('error', "You can't swap your own item!");
        }

        if (!$item->is_available) {
            return back()->with('error', 'This item is no longer available.');
        }

        $swap = Swap::create([
            'requester_id' => auth()->id(),
            'owner_id' => $item->user_id,
            'item_id' => $item->id,
            'offered_item_id' => $request->offered_item_id,
            'type' => 'direct',
            'message' => $request->message,
        ]);

        return back()->with('success', 'Swap request sent successfully!');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $item = Item::findOrFail($request->item_id);
        $user = auth()->user();

        if ($item->user_id === $user->id) {
            return back()->with('error', "You can't redeem your own item!");
        }

        if (!$item->is_available) {
            return back()->with('error', 'This item is no longer available.');
        }

        if ($user->points < $item->point_value) {
            return back()->with('error', 'Insufficient points to redeem this item.');
        }

        $swap = Swap::create([
            'requester_id' => $user->id,
            'owner_id' => $item->user_id,
            'item_id' => $item->id,
            'type' => 'points',
            'points_used' => $item->point_value,
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        $user->spendPoints($item->point_value, "Redeemed: {$item->title}", $swap);
        $item->user->addPoints($item->point_value * 0.6, "Item redeemed: {$item->title}", $swap);
        
        $item->markAsSwapped();

        return back()->with('success', 'Item redeemed successfully!');
    }

    public function accept(Swap $swap)
    {
        if ($swap->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $swap->accept();

        return back()->with('success', 'Swap request accepted!');
    }

    public function decline(Swap $swap)
    {
        if ($swap->owner_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $swap->update(['status' => 'declined']);

        return back()->with('success', 'Swap request declined.');
    }
}
