<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PostAdminController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $posts = Post::with('user')
            ->latest()
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'posts' => $posts,
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return back()->with('status', 'Post deleted.');
    }
}


