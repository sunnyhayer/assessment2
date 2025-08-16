<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::withCount('posts')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

      public function save(Request $request, $id = null)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($id) {
            // update existing
            $category = Category::findOrFail($id);
            $category->update($validated);
            return redirect()->route('categories.all')->with('success', 'Category updated successfully.');
        } else {
            // create new
            Category::create($validated);
            return redirect()->route('categories.all')->with('success', 'Category created successfully.');
        }
    }


    public function delete(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }
}
