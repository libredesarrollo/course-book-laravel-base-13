<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->regularUser = User::factory()->create(['role' => 'regular']);
});

describe('UserController', function () {

    describe('index', function () {
        it('displays users for admin', function () {
            $this->actingAs($this->admin);
            User::factory()->count(3)->create();

            $response = $this->get(route('user.index'));

            $response->assertSuccessful();
            $response->assertViewHas('users');
        });

        it('denies access for non-admin', function () {
            $this->actingAs($this->regularUser);

            $response = $this->get(route('user.index'));

            $response->assertStatus(403);
        });
    });

    describe('create', function () {
        it('shows create form for admin', function () {
            $this->actingAs($this->admin);

            $response = $this->get(route('user.create'));

            $response->assertSuccessful();
            $response->assertViewHas('user');
        });
    });

    describe('store', function () {
        it('creates a user with valid data', function () {
            $this->actingAs($this->admin);
            $userData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password123',
                'role' => 'regular',
            ];

            $response = $this->post(route('user.store'), $userData);

            $response->assertRedirect(route('user.index'));
            $this->assertDatabaseHas('users', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        });

        it('fails to create user with invalid data', function () {
            $this->actingAs($this->admin);
            $userData = [
                'name' => 'abc',
                'email' => 'invalid',
                'password' => '123',
            ];

            $response = $this->post(route('user.store'), $userData);

            $response->assertRedirect();
            $response->assertSessionHasErrors(['name', 'email', 'password']);
        });
    });

    describe('show', function () {
        it('displays a specific user', function () {
            $this->actingAs($this->admin);
            $user = User::factory()->create();

            $response = $this->get(route('user.show', $user));

            $response->assertSuccessful();
            $response->assertViewHas('user');
        });
    });

    describe('edit', function () {
        it('shows edit form for admin', function () {
            $this->actingAs($this->admin);
            $otherUser = User::factory()->create();

            $response = $this->get(route('user.edit', $otherUser));

            $response->assertSuccessful();
            $response->assertViewHas('user');
        });
    });

    describe('update', function () {
        it('updates user as admin', function () {
            $this->actingAs($this->admin);
            $otherUser = User::factory()->create();
            $updatedData = [
                'name' => 'Updated By Admin',
            ];

            $response = $this->put(route('user.update', $otherUser), $updatedData);

            $response->assertRedirect(route('user.index'));
            $this->assertDatabaseHas('users', [
                'id' => $otherUser->id,
                'name' => 'Updated By Admin',
            ]);
        });
    });

    describe('destroy', function () {
        it('deletes user as admin', function () {
            $this->actingAs($this->admin);
            $userToDelete = User::factory()->create();

            $response = $this->delete(route('user.destroy', $userToDelete));

            $response->assertRedirect(route('user.index'));
            $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
        });

        it('denies deletion for non-admin', function () {
            $this->actingAs($this->regularUser);
            $otherUser = User::factory()->create();

            $response = $this->delete(route('user.destroy', $otherUser));

            $response->assertStatus(403);
        });
    });
});
