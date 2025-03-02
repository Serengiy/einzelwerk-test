<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;

class UserController extends APIController
{
    public function me(): UserResource
    {
        return UserResource::make(auth()->user());
    }
}
