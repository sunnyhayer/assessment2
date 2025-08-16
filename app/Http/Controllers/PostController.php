<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with('category', 'user')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function edit(Post $post) 
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

   public function save(Request $request, $id = null)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ]);

    if ($id) {
        $post = Post::findOrFail($id);
        $post->update($validated);
        $message = 'Post updated successfully.';
    } else {
        $validated['user_id'] = Auth::id(); 
        Post::create($validated);
        $message = 'Post created successfully.';
    }

    return redirect()->route('posts.all')->with('success', $message);
}


    public function delete(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post deleted successfully.');
    }
}
