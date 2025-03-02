<?php

namespace App\Http\Controllers\API;


use App\Exceptions\HttpException;
use App\Http\Requests\API\LoginUserRequest;
use App\Http\Requests\API\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends APIController
{

    public function register(RegisterUserRequest $request): UserResource
    {
        $data = $request->getData();
        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->save();

        return UserResource::make($user);
    }

    /**
     * @throws HttpException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->getData();
        /** @var User $user */
        $user = User::query()->where('email', $data->email)->first();

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw new HttpException('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondWithWrapper([
            'token' => $token
        ]);
    }
}
