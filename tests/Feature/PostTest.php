<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_post()
    {
        $user = User::create([
            'username' => 'usercreate',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('posts.store'), [
            'status' => 'This is a test post content.',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'status',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'status' => 'This is a test post content.',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_view_a_single_post()
    {
        $user = User::create([
            'username' => 'userview',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $post = Post::create([
            'status' => 'This is a test post content.',
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(route('posts.show', $post->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'status',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertEquals($post->id, $response->json('data.id'));
    }

    public function test_user_can_view_all_posts()
    {
        $user = User::create([
            'username' => 'userviewall',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('posts.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);

        $this->assertCount(3, $response->json('data'));
    }

    public function test_user_can_update_a_post()
    {
        $user = User::create([
            'username' => 'userupdate',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $post = Post::create([
            'status' => 'Old content.',
            'user_id' => $user->id,
        ]);

        $response = $this->putJson(route('posts.update', $post->id), [
            'status' => 'New content.',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'New content.',
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'New content.',
        ]);
    }

    public function test_user_can_delete_a_post()
    {
        $user = User::create([
            'username' => 'userdelete',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $post = Post::create([
            'status' => 'This is a test post content.',
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson(route('posts.destroy', $post->id));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Post deleted successfully',
            ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_user_cannot_modify_others_post()
    {
        $user1 = User::create([
            'username' => 'user1',
            'password' => Hash::make('password123'),
        ]);

        $user2 = User::create([
            'username' => 'user2',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user1);

        $post = Post::create([
            'status' => 'Content belongs to user 2.',
            'user_id' => $user2->id,
        ]);

        $response = $this->putJson(route('posts.update', $post->id), [
            'status' => 'Unauthorized Update',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized',
            ]);
    }

    public function test_admin_can_delete_other_users_post()
    {
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'username' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $post = Post::create([
            'status' => 'This is a user-created post.',
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($admin);

        $response = $this->deleteJson(route('posts.destroy', $post->id));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Post deleted successfully',
            ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
