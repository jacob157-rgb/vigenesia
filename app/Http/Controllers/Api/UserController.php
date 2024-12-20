<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // User data related Controller
    public function user()
    {
        $user = User::find(Auth::id());

        $followerCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        return response()->json([
            'success' => true,
            'message' => 'user',
            'data' => [
                'user' => $user,
                'follower_count' => $followerCount,
                'following_count' => $followingCount,
            ],
        ], 200);
    }

    public function users()
    {
        $users = User::inRandomOrder()->take(25)->get();

        return response()->json([
            'success' => true,
            'message' => 'users',
            'users' => $users,
        ], 200);
    }

    public function username($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found',
            ], 404);
        }

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

        $followerCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        return response()->json([
            'success' => true,
            'message' => 'get by username',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'follower_count' => $followerCount,
                'following_count' => $followingCount,
                'posts' => $posts
            ],
        ], 200);
    }
    // End User data related Controller

    // Following unffollow logic
    public function follow(Request $request, $username)
    {
        $userToFollow = User::where('username', $username)->first();


        if (!$userToFollow) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $alreadyFollowing = Follower::where('follower_id', Auth::id())
            ->where('following_id', $userToFollow->id)
            ->exists();

        if ($alreadyFollowing) {
            return response()->json([
                'success' => false,
                'message' => 'You are already following this user',
            ], 400);
        }

        Follower::create([
            'follower_id' => Auth::id(),
            'following_id' => $userToFollow->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => "You are now following '$username'",
        ], 200);
    }

    public function unfollow(Request $request, $username)
    {
        $userToUnfollow = User::where('username', $username)->first();

        if (!$userToUnfollow) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $alreadyFollowing = Follower::where('follower_id', Auth::id())
            ->where('following_id', $userToUnfollow->id)
            ->exists();

        if (!$alreadyFollowing) {
            return response()->json([
                'success' => false,
                'message' => 'You are not following this user',
            ], 400);
        }

        Follower::where('follower_id', Auth::id())
            ->where('following_id', $userToUnfollow->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' =>  "You are now unfollowing '$username'",
        ], 200);
    }

    public function followers(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $followers = $user->followers;

        return response()->json([
            'success' => true,
            'message' => 'followers',
            'data' => $followers,
        ], 200);
    }

    public function followings(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $followings = $user->following;

        return response()->json([
            'success' => true,
            'message' => 'followings',
            'data' => $followings,
        ], 200);
    }
}
