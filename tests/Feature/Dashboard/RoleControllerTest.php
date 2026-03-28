<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->regularUser = User::factory()->create(['role' => 'regular']);
});

describe('RoleController', function () {

    describe('index', function () {
        it('displays roles for admin', function () {
            $this->actingAs($this->admin);
            Role::create(['name' => 'editor', 'guard_name' => 'web']);

            $response = $this->get(route('role.index'));

            $response->assertSuccessful();
            $response->assertViewHas('roles');
        });

        it('denies access for non-admin', function () {
            $this->actingAs($this->regularUser);

            $response = $this->get(route('role.index'));

            $response->assertRedirect();
        });
    });

    describe('create', function () {
        it('shows create form for admin', function () {
            $this->actingAs($this->admin);

            $response = $this->get(route('role.create'));

            $response->assertSuccessful();
            $response->assertViewHas('role');
        });
    });

    describe('store', function () {
        it('creates a role with valid data', function () {
            $this->actingAs($this->admin);
            $roleData = [
                'name' => 'editor',
                'guard_name' => 'web',
            ];

            $response = $this->post(route('role.store'), $roleData);

            $response->assertRedirect(route('role.index'));
            $this->assertDatabaseHas('roles', [
                'name' => 'editor',
            ]);
        });
    });

    describe('show', function () {
        it('displays a specific role', function () {
            $this->actingAs($this->admin);
            $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

            $response = $this->get(route('role.show', $role));

            $response->assertSuccessful();
            $response->assertViewHas('role');
        });
    });

    describe('edit', function () {
        it('shows edit form for role', function () {
            $this->actingAs($this->admin);
            $role = Role::create(['name' => 'contributor', 'guard_name' => 'web']);

            $response = $this->get(route('role.edit', $role));

            $response->assertSuccessful();
            $response->assertViewHas('role');
        });
    });

    describe('update', function () {
        it('updates role with valid data', function () {
            $this->actingAs($this->admin);
            $role = Role::create(['name' => 'old-role', 'guard_name' => 'web']);
            $updatedData = [
                'name' => 'updated-editor',
                'guard_name' => 'web',
            ];

            $response = $this->put(route('role.update', $role), $updatedData);

            $response->assertRedirect(route('role.index'));
            $this->assertDatabaseHas('roles', [
                'id' => $role->id,
                'name' => 'updated-editor',
            ]);
        });
    });

    describe('destroy', function () {
        it('deletes a role', function () {
            $this->actingAs($this->admin);
            $role = Role::create(['name' => 'temporary-role', 'guard_name' => 'web']);

            $response = $this->delete(route('role.destroy', $role));

            $response->assertRedirect(route('role.index'));
            $this->assertDatabaseMissing('roles', ['id' => $role->id]);
        });
    });
});
