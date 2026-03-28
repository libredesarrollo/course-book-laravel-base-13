<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->regularUser = User::factory()->create(['role' => 'regular']);
    $this->category = Category::factory()->create();
});

describe('PostController', function () {

    describe('index', function () {
        it('displays all posts', function () {
            $this->actingAs($this->admin);
            $post = Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
            ]);

            $response = $this->get(route('post.index'));

            $response->assertSuccessful();
            $response->assertViewHas('posts');
        });
    });

    describe('create', function () {
        it('shows create form with categories', function () {
            $this->actingAs($this->admin);

            $response = $this->get(route('post.create'));

            $response->assertSuccessful();
            $response->assertViewHas('categories');
            $response->assertViewHas('post');
        });
    });

    describe('store', function () {
        it('creates a post with valid data', function () {
            $this->actingAs($this->admin);
            $postData = [
                'title' => 'Test Post Title',
                'slug' => 'test-post-slug',
                'content' => 'Test post content here',
                'description' => 'Test description',
                'posted' => 'yes',
                'category_id' => $this->category->id,
            ];

            $response = $this->post(route('post.store'), $postData);

            $response->assertRedirect(route('post.index'));
            $this->assertDatabaseHas('posts', [
                'title' => 'Test Post Title',
                'slug' => 'test-post-slug',
            ]);
        });

        it('fails to create post with invalid data', function () {
            $this->actingAs($this->admin);
            $postData = [
                'title' => 'Abc',
                'slug' => 'xyz',
                'content' => 'abc',
                'description' => 'abc',
                'category_id' => '',
            ];

            $response = $this->post(route('post.store'), $postData);

            $response->assertRedirect();
            $response->assertSessionHasErrors(['title', 'slug', 'content', 'description', 'category_id']);
        });
    });

    describe('show', function () {
        it('displays a specific post', function () {
            $this->actingAs($this->admin);
            $post = Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
            ]);

            $response = $this->get(route('post.show', $post));

            $response->assertSuccessful();
            $response->assertViewHas('post');
        });
    });

    describe('edit', function () {
        it('shows edit form for post', function () {
            $this->actingAs($this->admin);
            $post = Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
            ]);

            $response = $this->get(route('post.edit', $post));

            $response->assertSuccessful();
            $response->assertViewHas('post');
            $response->assertViewHas('categories');
        });
    });

    describe('update', function () {
        it('updates post with valid data', function () {
            $this->actingAs($this->admin);
            $post = Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
            ]);
            $updatedData = [
                'title' => 'Updated Post Title',
                'slug' => 'updated-post-slug',
                'content' => 'Updated post content',
                'description' => 'Updated description',
                'posted' => 'yes',
                'category_id' => $this->category->id,
            ];

            $response = $this->put(route('post.update', $post), $updatedData);

            $response->assertRedirect(route('post.index'));
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'title' => 'Updated Post Title',
            ]);
        });
    });

    describe('destroy', function () {
        it('deletes a post as owner', function () {
            $this->actingAs($this->admin);
            $post = Post::factory()->create(['user_id' => $this->admin->id, 'category_id' => $this->category->id]);

            $response = $this->delete(route('post.destroy', $post));

            $response->assertRedirect(route('post.index'));
            $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        });

        it('denies deletion for non-owner', function () {
            $otherUser = User::factory()->create();
            $this->actingAs($otherUser);
            $post = Post::factory()->create(['user_id' => $this->admin->id, 'category_id' => $this->category->id]);

            $response = $this->delete(route('post.destroy', $post));

            $response->assertForbidden();
        });
    });
});
