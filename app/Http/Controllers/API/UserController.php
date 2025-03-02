<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;

class UserController extends APIController
{
    /**
     * Get the authenticated user
     *
     * This endpoint retrieves the currently authenticated user's information.
     *
     * @group Uer
     *
     * @authenticated
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "john@example.com",
     *   "email_verified_at": "2024-03-01 12:00:00"
     * }
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function me(): UserResource
    {
        return UserResource::make(auth()->user());
    }
}
