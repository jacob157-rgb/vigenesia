<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'followed');
        $limit = $request->query('limit', 10);
        $user = User::find(Auth::id());

        if ($filter === 'my') {
            $posts = Post::with('user')->where('user_id', $user->id)->paginate($limit);
        } elseif ($filter === 'random') {
            $posts = Post::with('user')->inRandomOrder()->paginate($limit);
        } else {
            $followingIds = $user->following()->pluck('id'); // Asumsi ada relasi 'following'
            $posts = Post::with('user')->whereIn('user_id', $followingIds)->paginate($limit);
        }

        return response()->json([
            'success' => true,
            'data' => $posts,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $post = Post::create([
            'status' => $validated['status'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $post,
        ], 201);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required',
        ]);

        $post->update($validated);

        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        // Check if the authenticated user is the owner of the post or an admin
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
        ], 200);
    }
}
