<?php

use App\Models\Trips\Trip;

it('can create a new trip', function () {
    $model = Trip::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can create a new trip stations', function () {
    $trips = \App\Models\Trips\TripStation::factory(12)->for(Trip::factory(), 'trip')->create();
    test()->assertDatabaseCount($trips->first->getTable(), 12);
});
