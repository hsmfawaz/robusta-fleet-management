<?php

use App\Models\Station;

it('can create a new station', function () {
    $model = Station::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can view index page', function () {
    asAdmin()->get(route('core.stations.index'))->assertOk();
});

it('can view create page', function () {
    asAdmin()->get(route('core.stations.create'))->assertOk();
});

it('can view edit page', function () {
    $model = Station::factory()->create();
    asAdmin()->get(route('core.stations.edit', $model))->assertOk();
});

it('can delete record ', function () {
    $model = Station::factory()->create();
    asAdmin()->delete(route('core.stations.destroy', $model))->assertOk();
    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
});