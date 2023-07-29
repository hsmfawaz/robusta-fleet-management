<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginUserController
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $model = User::where('email', $validated['email'])->first();

        if (! $model || ! Hash::check($validated['password'], $model->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Credentials doesnt match',
            ], 401);
        }

        $model->forceFill([
            'token' => $model->createToken('api-token')->plainTextToken,
        ]);

        return response()->json([
            'status' => true,
            'data' => new UserResource($model),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
