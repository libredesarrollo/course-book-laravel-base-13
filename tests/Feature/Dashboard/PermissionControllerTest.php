<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->regularUser = User::factory()->create(['role' => 'regular']);
});

describe('PermissionController', function () {

    describe('index', function () {
        it('displays permissions for admin', function () {
            $this->actingAs($this->admin);
            Permission::create(['name' => 'test.permission', 'guard_name' => 'web']);

            $response = $this->get(route('permission.index'));

            $response->assertSuccessful();
            $response->assertViewHas('permissions');
        });

        it('denies access for non-admin', function () {
            $this->actingAs($this->regularUser);

            $response = $this->get(route('permission.index'));

            $response->assertRedirect();
        });
    });

    describe('create', function () {
        it('shows create form for admin', function () {
            $this->actingAs($this->admin);

            $response = $this->get(route('permission.create'));

            $response->assertSuccessful();
            $response->assertViewHas('permission');
        });
    });

    describe('store', function () {
        it('creates a permission with valid data', function () {
            $this->actingAs($this->admin);
            $permissionData = [
                'name' => 'editor.posts.create',
                'guard_name' => 'web',
            ];

            $response = $this->post(route('permission.store'), $permissionData);

            $response->assertRedirect(route('permission.index'));
            $this->assertDatabaseHas('permissions', [
                'name' => 'editor.posts.create',
            ]);
        });
    });

    describe('show', function () {
        it('displays a specific permission', function () {
            $this->actingAs($this->admin);
            $permission = Permission::create(['name' => 'test.show', 'guard_name' => 'web']);

            $response = $this->get(route('permission.show', $permission));

            $response->assertSuccessful();
            $response->assertViewHas('permission');
        });
    });

    describe('edit', function () {
        it('shows edit form for permission', function () {
            $this->actingAs($this->admin);
            $permission = Permission::create(['name' => 'test.edit', 'guard_name' => 'web']);

            $response = $this->get(route('permission.edit', $permission));

            $response->assertSuccessful();
            $response->assertViewHas('permission');
        });
    });

    describe('update', function () {
        it('updates permission with valid data', function () {
            $this->actingAs($this->admin);
            $permission = Permission::create(['name' => 'test.update', 'guard_name' => 'web']);
            $updatedData = [
                'name' => 'editor.posts.update',
                'guard_name' => 'web',
            ];

            $response = $this->put(route('permission.update', $permission), $updatedData);

            $response->assertRedirect(route('permission.index'));
            $this->assertDatabaseHas('permissions', [
                'id' => $permission->id,
                'name' => 'editor.posts.update',
            ]);
        });
    });

    describe('destroy', function () {
        it('deletes a permission', function () {
            $this->actingAs($this->admin);
            $permission = Permission::create(['name' => 'test.delete', 'guard_name' => 'web']);

            $response = $this->delete(route('permission.destroy', $permission));

            $response->assertRedirect(route('permission.index'));
            $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
        });
    });
});
