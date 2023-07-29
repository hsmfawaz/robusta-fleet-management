<?php

use App\Models\Booking;

it('can create a new booking', function () {
    $model = Booking::factory()->create();
    $this->assertDatabaseHas($model->getTable(), ['id' => $model->id]);
});
it('can view index bookings page', function () {
    asAdmin()->get(route('bookings.index'))->assertOk();
});
it('can  delete bookings ', function () {
    $model = Booking::factory()->create();
    asAdmin()->delete(route('bookings.destroy', $model))->assertOk();
    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);
});
