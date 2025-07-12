<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = Item::approved()
            ->available()
            ->with(['user', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('items')->get();

        return view('welcome', compact('featuredItems', 'categories'));
    }
}
