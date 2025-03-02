<?php

namespace Tests\Feature\API\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserCanBeLoggedInTest extends TestCase
{

    public function test_user_can_be_logged_in(): void
    {
        $user = User::query()->inRandomOrder()->first();
        $this->assertNotNull($user);

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'meta',
            'data' => [
                'token',
            ]
        ]);
    }
}
