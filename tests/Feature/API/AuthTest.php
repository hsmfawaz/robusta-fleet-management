<?php

use App\Models\User;

it('can register new user', function () {
    $data = User::factory()->raw();
    $data['password_confirmation'] = $data['password'];
    $response = $this->postJson('api/auth/register', $data)->assertStatus(201);
    expect($response['data']['token'])->not->toBeEmpty();
});

it('can login user', function () {
    $data = User::factory()->create(['password' => 'secret']);
    $response = $this->postJson('api/auth/login', [
        'email' => $data->email,
        'password' => 'secret',
    ])
        ->assertStatus(200)
        ->assertJsonPath('data.id', $data->id)
        ->assertJsonPath('data.name', $data->name);

    expect($response['data']['token'])->not->toBeEmpty();
});

it('can logout successfully', function () {
    $data = User::factory()->create(['password' => 'secret']);
    $token = $data->createToken('api-token')->plainTextToken;
    $this->withToken($token)->deleteJson('api/auth/logout')
        ->assertStatus(204);
});
