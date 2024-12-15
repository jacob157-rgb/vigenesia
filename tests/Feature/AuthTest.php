<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'username' => 'testuserregister',
        'password' => 'securepassword',
        'password_confirmation' => 'securepassword',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'role',
                    'username',
                    'created_at',
                    'updated_at',
                ],
                'follower_count',
                'following_count',
            ],
            'access_token',
        ]);

    expect(User::where('username', 'testuserregister')->exists())->toBeTrue();
});

it('can login with valid credentials', function () {
    $user = User::factory()->create([
        'username' => 'testuserlogin',
        'password' => Hash::make('securepassword'),
    ]);

    $response = $this->postJson('/api/login', [
        'username' => 'testuserlogin',
        'password' => 'securepassword',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'role',
                    'username',
                    'created_at',
                    'updated_at',
                ],
                'follower_count',
                'following_count',
            ],
            'access_token',
        ]);
});

it('cannot login with unexisted credentials', function () {
    $response = $this->postJson('/api/login', [
        'username' => 'invaliduser',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => ''
        ]);
});

it('cannot login with invalid credentials', function () {
    User::factory()->create([
        'username' => 'testusercredentials',
        'password' => Hash::make('securepassword'),
    ]);

    $response = $this->postJson('/api/login', [
        'username' => 'testusercredentials',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'unauthorized',
        ]);
});

it('can logout an authenticated user', function () {
    $testuser = User::factory()->create([
        'username' => 'testuserlogout',
        'password' => Hash::make('securepassword'),
    ]);

    Sanctum::actingAs($testuser);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'logout',
        ]);
});

it('cannot access protected routes without authentication', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401);
});

it('can access user information with valid token', function () {
    $testuser = User::factory()->create([
        'username' => 'testuser',
        'password' => Hash::make('securepassword'),
    ]);

    Sanctum::actingAs($testuser);

    $response = $this->getJson('/api/user');

    $response->assertStatus(200);

    $response->assertJson([
        "id" => $testuser->id,
        "username" => $testuser->username,
        "role" => $testuser->role,
        "created_at" => $testuser->created_at->toISOString(),
        "updated_at" => $testuser->updated_at->toISOString(),
    ]);
});
