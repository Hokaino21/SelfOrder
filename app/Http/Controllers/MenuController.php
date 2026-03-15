<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        if ($category === 'all') {
            $menuItems = \App\Models\MenuItem::where('is_available', true)->get();
        } else {
            $menuItems = \App\Models\MenuItem::where('category', $category)
                ->where('is_available', true)
                ->get();
        }

        $categories = \App\Models\MenuItem::distinct('category')->pluck('category');

        return view('menu.index', compact('menuItems', 'categories', 'category'));
    }

    public function show($id)
    {
        $menuItem = \App\Models\MenuItem::findOrFail($id);
        return view('menu.show', compact('menuItem'));
    }
}
