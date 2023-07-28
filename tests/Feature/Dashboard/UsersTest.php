<?php

use App\Models\User;

it('can create a new user', function () {
    $model = User::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});

it('can view index page', function () {
    asAdmin()->get(route('users.index'))->assertOk();
});

it('can view create page', function () {
    asAdmin()->get(route('users.create'))->assertOk();
});

it('can view edit page', function () {
    $model = User::factory()->create();
    asAdmin()->get(route('users.edit', $model))->assertOk();
});

it('can delete record ', function () {
    $model = User::factory()->create();
    asAdmin()->delete(route('users.destroy', $model))->assertOk();
    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
});