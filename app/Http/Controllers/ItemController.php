<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::approved()->available()->with(['user', 'category']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    public function show(Item $item)
    {
        $item->load(['user', 'category']);
        $relatedItems = Item::approved()
            ->available()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->take(4)
            ->get();

        return view('items.show', compact('item', 'relatedItems'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'size' => 'required|in:xs,s,m,l,xl,xxl',
            'condition' => 'required|in:new,excellent,good,fair',
            'type' => 'required|in:tops,bottoms,dresses,outerwear,shoes,accessories',
            'tags' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item = new Item($request->all());
        $item->user_id = auth()->id();
        $item->tags = $request->tags ? explode(',', $request->tags) : [];

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
            $item->images = $imagePaths;
        }

        $item->save();

        return redirect()->route('dashboard')->with('success', 'Item submitted for approval!');
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'size' => 'required|in:xs,s,m,l,xl,xxl',
            'condition' => 'required|in:new,excellent,good,fair',
            'type' => 'required|in:tops,bottoms,dresses,outerwear,shoes,accessories',
            'tags' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item->fill($request->all());
        $item->tags = $request->tags ? explode(',', $request->tags) : [];

        if ($request->hasFile('images')) {
            if ($item->images) {
                foreach ($item->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
            $item->images = $imagePaths;
        }

        $item->save();

        return redirect()->route('dashboard')->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        if ($item->images) {
            foreach ($item->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $item->delete();

        return redirect()->route('dashboard')->with('success', 'Item deleted successfully!');
    }
}
