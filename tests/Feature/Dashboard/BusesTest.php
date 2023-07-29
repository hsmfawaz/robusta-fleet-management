<?php

use App\Models\Buses\Bus;

it('can create a new bus', function () {
    $model = Bus::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can create a new bus seats', function () {
    Bus::factory()->create();
    test()->assertDatabaseCount('bus_seats', 12);
});
it('can view index page', function () {
    asAdmin()->get(route('core.buses.index'))->assertOk();
});

it('can view create page', function () {
    asAdmin()->get(route('core.buses.create'))->assertOk();
});

it('can view edit page', function () {
    $model = Bus::factory()->create();
    asAdmin()->get(route('core.buses.edit', $model))->assertOk();
});

it('can delete record ', function () {
    $model = Bus::factory()->create();
    asAdmin()->delete(route('core.buses.destroy', $model))->assertOk();
    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
});
