<?php

use App\Models\Booking;

it('can create a new booking', function () {
    $model = Booking::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
