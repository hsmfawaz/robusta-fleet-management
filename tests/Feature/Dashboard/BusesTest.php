<?php

use App\Models\Buses\Bus;

it("can create a new bus", function () {
    $model = Bus::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it("can create a new bus seats", function () {
    $trips = \App\Models\Buses\BusSeat::factory(12)->for(Bus::factory(), 'bus')->create();
    test()->assertDatabaseCount($trips->first->getTable(), 12);
});