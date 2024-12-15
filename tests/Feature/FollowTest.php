<?php

use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

it('can follow another user', function () {
    // Create two users
    $user1 = User::create([
        'username' => 'user1follow',
        'password' => Hash::make('password123'),
    ]);

    $user2 = User::create([
        'username' => 'user2follow',
        'password' => Hash::make('password123'),
    ]);

    // Authenticate as user1
    Sanctum::actingAs($user1);

    // Attempt to follow user2
    $response = $this->postJson(route('follow', $user2->id));

    // Assert HTTP status
    $response->assertStatus(200);

    // Assert JSON response
    $response->assertJson([
        'success' => true,
        'message' => 'You are now following this user',
    ]);

    // Verify database record exists
    $this->assertDatabaseHas('followers', [
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
    ]);
});


it('can unfollow a user', function () {
    // Create two users
    $user1 = User::create([
        'username' => 'user1unfollow',
        'password' => Hash::make('password123'),
    ]);

    $user2 = User::create([
        'username' => 'user2unfollow',
        'password' => Hash::make('password123'),
    ]);

    // Authenticate as user1
    Sanctum::actingAs($user1);

    // Establish follow relationship
    Follower::create([
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
    ]);

    // Attempt to unfollow user2
    $response = $this->postJson(route('unfollow', $user2->id));

    // Assert HTTP status
    $response->assertStatus(200);

    // Assert JSON response
    $response->assertJson([
        'success' => true,
        'message' => 'You have unfollowed this user',
    ]);

    // Verify database record is deleted
    $this->assertDatabaseMissing('followers', [
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
    ]);
});


it('can get a list of followers', function () {
    $user1 = User::create([
        'username' => 'user1followers',
        'password' => Hash::make('password123'),
    ]);

    $user2 = User::create([
        'username' => 'user2followers',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user2);

    $user2->following()->attach($user1->id);

    $response = $this->getJson(route('followers', $user1->id));

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'success',
        'data' => [
            '*' => [
                'id',
                'username',
                'role',
                'created_at',
                'updated_at',
                'pivot' => [
                    'following_id',
                    'follower_id',
                ],
            ],
        ],
    ]);

    $response->assertJsonFragment([
        'username' => 'user2followers',
    ]);

    $response->assertJsonFragment([
        'follower_id' => $user2->id,
        'following_id' => $user1->id,
    ]);
});


it('can get a list of following users', function () {
    $user1 = User::create([
        'username' => 'user1following',
        'password' => Hash::make('password123'),
    ]);

    $user2 = User::create([
        'username' => 'user2following',
        'password' => Hash::make('password123'),
    ]);

    Sanctum::actingAs($user1);

    $user1->following()->attach($user2->id);

    $response = $this->getJson(route('following', $user1->id));

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'success',
        'data' => [
            '*' => [
                'id',
                'username',
                'role',
                'created_at',
                'updated_at',
                'pivot' => [
                    'following_id',
                    'follower_id',
                ],
            ],
        ],
    ]);

    $response->assertJsonFragment([
        'username' => 'user2following',
    ]);

    $response->assertJsonFragment([
        'follower_id' => $user1->id,
        'following_id' => $user2->id,
    ]);
});
