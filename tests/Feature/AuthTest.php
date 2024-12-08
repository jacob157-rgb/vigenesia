<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'username' => 'testuser',
        'password' => 'securepassword',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => ['id', 'username'],
            'access_token',
            'token_type',
        ]);

    expect(User::where('username', 'testuser')->exists())->toBeTrue();
});

it('can login with valid credentials', function () {
    $response = $this->postJson('/api/login', [
        'username' => 'admin',
        'password' => 'admin',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'access_token',
            'token_type',
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
        ]);
});

it('cannot login with invalid credentials', function () {
    $response = $this->postJson('/api/login', [
        'username' => 'admin',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthorized',
        ]);
});

it('can logout an authenticated user', function () {
    $admin = User::where('username', 'admin')->first();

    expect($admin)->not->toBeNull();

    Sanctum::actingAs($admin);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Logout Success',
        ]);
});

it('cannot access protected routes without authentication', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401);
});

it('can access user information with valid token', function () {
    $admin = User::where('username', 'admin')->first();

    expect($admin)->not->toBeNull();

    Sanctum::actingAs($admin);

    $response = $this->getJson('/api/user');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'username',
            'role',
            'created_at',
            'updated_at'
        ]);
});
