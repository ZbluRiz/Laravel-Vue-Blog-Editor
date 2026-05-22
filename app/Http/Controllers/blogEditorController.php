<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogEditorController extends Controller
{
    public function index()
    {
        $blogs = Post::with(['user', 'comments.user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->get();

        return Inertia::render('Blogs/Index', [
            'blogs' => $blogs,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:25000',
        ]);

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('blogs')->with('success', 'Blog posted successfully!');
    }

    public function edit(Post $blog)
    {
        return Inertia::render('Blogs/Edit', ['blog' => $blog]);
    }

    public function update(Request $request, Post $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:25000',
        ]);

        $blog->update($validated);

        return redirect()->route('blogs')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('blogs')->with('success', 'Blog deleted.');
    }
}