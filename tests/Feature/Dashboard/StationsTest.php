<?php

use App\Models\Station;

it("can create a new station", function () {
    $model = Station::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
