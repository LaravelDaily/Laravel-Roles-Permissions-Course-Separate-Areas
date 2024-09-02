<?php

use App\Models\User;
use App\Models\Task;
use function Pest\Laravel\actingAs;

it('allows users to access tasks page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('user.tasks.index'))
        ->assertOk();
});

it('does not allow users to access admin task page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.tasks.index'))
        ->assertForbidden();
});

it('allows administrator to access tasks page', function () {
    $user = User::factory()->create(['is_admin' => true]);

    actingAs($user)
        ->get(route('admin.tasks.index'))
        ->assertOk();
});
