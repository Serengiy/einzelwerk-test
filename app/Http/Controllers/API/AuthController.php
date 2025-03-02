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
    /**
     * Register a new user
     *
     * This endpoint allows users to create an account by providing their name, email, and password.
     *
     * @group Authentication
     *
     * @bodyParam name string required The full name of the user. Max: 255 characters. Example: "John Doe"
     * @bodyParam email string required A valid and unique email address. Max: 255 characters. Example: "john@example.com"
     * @bodyParam password string required A password with at least 8 characters. Must be confirmed. Example: "password123"
     * @bodyParam password_confirmation string required Must match the password. Example: "password123"
     *
     * @response 201 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "john@example.com"
     * }
     * @response 422 {
     *   "message": "The email has already been taken.",
     *   "errors": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
     */
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
     * User login
     *
     * This endpoint allows users to log in using their email and password.
     *
     * @group Authentication
     *
     * @bodyParam email string required A registered email address. Max: 255 characters. Example: "john@example.com"
     * @bodyParam password string required The user's password. Example: "password123"
     *
     * @response 200 {
     *   "token": "2|abc123456789xyz"
     * }
     * @response 401 {
     *   "message": "Invalid credentials"
     * }
     * @response 422 {
     *   "message": "The email field is required.",
     *   "errors": {
     *     "email": ["The email field is required."]
     *   }
     * }
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
