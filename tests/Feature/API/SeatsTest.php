<?php


use App\Models\Buses\BusSeat;
use App\Models\User;
use Database\Factories\Trips\TripFactory;

it("can get available sets only", function () {
    [, $stations] = TripFactory::createTaskTrip();

    $this->getJson('api/seats?from='.$stations['Cairo']->id.'&to='.$stations['AlMinya']->id)
         ->assertStatus(200)
         ->assertJsonCount(12, 'data.items');
});

it("can book an available seat", function () {
    $user = User::factory()->create()->createToken('test')->plainTextToken;
    [, $stations] = TripFactory::createTaskTrip();

    $from = $stations['Cairo']->id;
    $to = $stations['AlMinya']->id;


    $list = function ($from, $to, $count = 12) {
        return $this->getJson('api/seats?from='.$from.'&to='.$to)
                    ->assertStatus(200)
                    ->assertJsonCount($count, 'data.items');
    };
    $seat = $list($from, $to)->json('data.items.0.id');

    $this->withToken($user)
         ->postJson('api/seats/'.$seat, [
             'from' => $from,
             'to'   => $to,
         ])
         ->assertStatus(201)
         ->assertJsonPath('data.seat.id', $seat)
         ->assertJsonPath('data.from.id', $from)
         ->assertJsonPath('data.to.id', $to);

    $list($from, $to, 11);

});

it("cannot book an unavailable seat", function () {
    $user = User::factory()->create()->createToken('test')->plainTextToken;
    [, $stations] = TripFactory::createTaskTrip();
    $seat = BusSeat::factory()->create()->id;
    $from = $stations['Cairo']->id;
    $to = $stations['AlMinya']->id;

    $this->withToken($user)
         ->postJson('api/seats/'.$seat, [
             'from' => $from,
             'to'   => $to,
         ])
         ->assertStatus(422);
});
