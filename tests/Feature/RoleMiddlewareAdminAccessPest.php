<?php

use App\Models\Role;
use App\Models\User;

function admin_root_url(): string
{
    return '/admin';
}

test('guest cannot access admin routes protected by RoleMiddleware', function () {
    $response = $this->get(admin_root_url());

    $response->assertStatus(403);
});

test('non-admin users are denied access to admin routes', function () {
    $roleUser = Role::query()->where('name', 'user')->first();

    $user = User::factory()->create([
        'role_id' => $roleUser?->id,
        'enable' => 1,
    ]);

    $response = $this->actingAs($user)->get(admin_root_url());

    $response->assertStatus(403);
});

test('admin users are allowed access to admin routes', function () {
    $roleAdmin = Role::query()->where('name', 'admin')->first();

    $user = User::factory()->create([
        'role_id' => $roleAdmin?->id,
        'enable' => 1,
    ]);

    $response = $this->actingAs($user)->get(admin_root_url());

    $response->assertStatus(200);
});

