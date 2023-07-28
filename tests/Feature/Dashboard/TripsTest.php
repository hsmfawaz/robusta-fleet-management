<?php

use App\Models\Trips\Trip;

it('can create a new trip', function () {
    $model = Trip::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can create a new trip stations', function () {
    $trip = Trip::factory()->create();
    test()->assertDatabaseCount('trip_stations', $trip->stations->count());
});
it('can view index page', function () {
    asAdmin()->get(route('core.trips.index'))->assertOk();
});

it('can view create page', function () {
    asAdmin()->get(route('core.trips.create'))->assertOk();
});

it('can view edit page', function () {
    $model = Trip::factory()->create();
    asAdmin()->get(route('core.trips.edit', $model))->assertOk();
});

it('can delete record ', function () {
    $model = Trip::factory()->create();
    asAdmin()->delete(route('core.trips.destroy', $model))->assertOk();
    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
});