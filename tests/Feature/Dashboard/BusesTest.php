<?php

use App\Models\Buses\Bus;

it('can create a new bus', function () {
    $model = Bus::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can create a new bus seats', function () {
    $models = Bus::factory()->create();
    test()->assertDatabaseCount('bus_seats', 12);
});
