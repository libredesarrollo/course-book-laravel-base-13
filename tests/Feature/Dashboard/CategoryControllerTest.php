<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->regularUser = User::factory()->create(['role' => 'regular']);
});

describe('CategoryController', function () {

    describe('index', function () {
        it('displays categories for admin', function () {
            $this->actingAs($this->admin);
            Category::factory()->count(3)->create();

            $response = $this->get(route('category.index'));

            $response->assertSuccessful();
            $response->assertViewHas('categories');
        });
    });

    describe('create', function () {
        it('shows create form for admin', function () {
            $this->actingAs($this->admin);

            $response = $this->get(route('category.create'));

            $response->assertSuccessful();
            $response->assertViewHas('category');
        });
    });

    describe('store', function () {
        it('creates a category with valid data', function () {
            $this->actingAs($this->admin);
            $categoryData = [
                'title' => 'Test Category Title',
                'slug' => 'test-category-slug',
            ];

            $response = $this->post(route('category.store'), $categoryData);

            $response->assertRedirect(route('category.index'));
            $this->assertDatabaseHas('categories', [
                'title' => 'Test Category Title',
                'slug' => 'test-category-slug',
            ]);
        });

        it('fails to create category with invalid data', function () {
            $this->actingAs($this->admin);
            $categoryData = [
                'title' => 'Abc',
                'slug' => 'xyz',
            ];

            $response = $this->post(route('category.store'), $categoryData);

            $response->assertRedirect();
            $response->assertSessionHasErrors(['title', 'slug']);
        });

        it('auto-generates slug from title when not provided', function () {
            $this->actingAs($this->admin);
            $categoryData = [
                'title' => 'Auto Generated Slug Category',
            ];

            $response = $this->post(route('category.store'), $categoryData);

            $response->assertRedirect(route('category.index'));
            $this->assertDatabaseHas('categories', [
                'title' => 'Auto Generated Slug Category',
                'slug' => 'auto-generated-slug-category',
            ]);
        });
    });

    describe('show', function () {
        it('displays a specific category', function () {
            $this->actingAs($this->admin);
            $category = Category::factory()->create();

            $response = $this->get(route('category.show', $category));

            $response->assertSuccessful();
            $response->assertViewHas('category');
        });
    });

    describe('edit', function () {
        it('shows edit form for category', function () {
            $this->actingAs($this->admin);
            $category = Category::factory()->create();

            $response = $this->get(route('category.edit', $category));

            $response->assertSuccessful();
            $response->assertViewHas('category');
        });
    });

    describe('update', function () {
        it('updates category with valid data', function () {
            $this->actingAs($this->admin);
            $category = Category::factory()->create();
            $updatedData = [
                'title' => 'Updated Category Title',
                'slug' => 'updated-category-slug',
            ];

            $response = $this->put(route('category.update', $category), $updatedData);

            $response->assertRedirect(route('category.index'));
            $this->assertDatabaseHas('categories', [
                'id' => $category->id,
                'title' => 'Updated Category Title',
            ]);
        });

        it('fails to update category with invalid data', function () {
            $this->actingAs($this->admin);
            $category = Category::factory()->create();
            $updatedData = [
                'title' => 'abc',
                'slug' => 'ab',
            ];

            $response = $this->put(route('category.update', $category), $updatedData);

            $response->assertSessionHasErrors(['title', 'slug']);
        });
    });

    describe('destroy', function () {
        it('deletes a category', function () {
            $this->actingAs($this->admin);
            $category = Category::factory()->create();

            $response = $this->delete(route('category.destroy', $category));

            $response->assertRedirect(route('category.index'));
            $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        });
    });
});
