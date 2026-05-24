<?php

use App\Models\Role;
use App\Models\User;

function admin_route_url(): string {
    return route('admin.dashboard.index');
}




test('non authentifié ne peut pas accéder à une route admin protégée par RoleMiddleware', function () {
    $response = $this->get(admin_route_url());

    // Selon la config d'auth, on peut être redirigé vers la page de login (302)
    // ou recevoir un 403 directement.
    $response->assertStatus(302);

});

test('un utilisateur non-admin sans permission route est refusé (403) pour une route admin', function () {
    $roleUser = Role::query()->where('name', 'user')->first();

    $user = User::factory()->create([
        'role_id' => $roleUser?->id,
        'enable' => 1,
    ]);

    $response = $this->actingAs($user)->get(admin_route_url());

    $response->assertStatus(403);
});

test('un admin accède à la route admin', function () {
    $roleAdmin = Role::query()->where('name', 'admin')->first();

    $user = User::factory()->create([
        'role_id' => $roleAdmin?->id,
        'enable' => 1,
    ]);

    $response = $this->actingAs($user)->get(admin_route_url());

    // On ne teste pas la vue (dépend de settings/env), ici on vérifie surtout que le middleware n’interdit pas l’accès.
    $this->assertNotEquals(403, $response->getStatusCode());


});

