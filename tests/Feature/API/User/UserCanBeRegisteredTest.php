<?php

namespace Feature\API\User;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserCanBeRegisteredTest extends TestCase
{
    public function test_non_auth_user_can_be_registered(): void
    {
        $data = [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'email_verified_at',
            ],
        ]);
    }
}
