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
        $postsType = $request->query('type');
        $user = User::find(Auth::id());
        $followerCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $posts = [];
        $message = '';

        if ($postsType === 'followed') {
            $message = 'get user followed posts';
            $posts = Post::whereIn('user_id', function ($query) {
                $query->select('following_id')
                    ->from('followers')
                    ->where('follower_id', Auth::id());
            })->inRandomOrder()->latest()->take(20)->get()->map(function ($post) use ($user) {
                return [
                    'id' => $post->id,
                    'status' => $post->status,
                    'user' => [
                        'id' => $post->user->id,
                        'username' => $post->user->username,
                    ],
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ];
            });
        } elseif ($postsType === 'random') {
            $message = 'get user random posts';
            $posts = Post::whereIn('user_id', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('id', '<>', Auth::id());
            })->inRandomOrder()->take(20)->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'status' => $post->status,
                    'user' => [
                        'id' => $post->user->id,
                        'username' => $post->user->username,
                    ],
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ];
            });
        } elseif ($postsType === 'my') {
            $message = 'get user auth posts';
            $posts = $user->posts()->latest()->take(20)->get()->map(function ($post) use ($user) {
                return [
                    'id' => $post->id,
                    'status' => $post->status,
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                    ],
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ];
            });
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid type parameter'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'follower_count' => $followerCount,
                'following_count' => $followingCount,
                'posts' => $posts,
            ],
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
            'message' => 'post created',
            'post' => $post,
        ], 201);
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
            'message' => 'post updated',
            'post' => $post,
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
            'message' => 'post deleted',
        ], 200);
    }
}
