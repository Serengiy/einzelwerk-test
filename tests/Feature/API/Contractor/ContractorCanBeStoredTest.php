<?php

namespace Feature\API\Contractor;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class
ContractorCanBeStoredTest extends TestCase
{
    public function test_contragent_can_be_stored(): void
    {
        $user = $this->createUser();
        $data = [
            'inn' => '370702075306',
            'user_id' => User::query()->whereDoesntHave('contragent')->first()->id,
        ];

        $response = $this->actingAs($user)->postJson('/api/contragents', $data);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
