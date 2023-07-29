<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterUserController
{
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();
        $model = $this->createUser($validated);

        return response()->json([
            'status' => true,
            'data' => new UserResource($model),
        ], Response::HTTP_CREATED);
    }

    protected function createUser(mixed $validated)
    {
        $model = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $model->forceFill([
            'token' => $model->createToken('api-token')->plainTextToken,
        ]);

        return $model;
    }
}
