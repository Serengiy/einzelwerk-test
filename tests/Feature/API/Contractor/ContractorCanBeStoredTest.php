<?php

namespace Tests\Feature\API\Contractor;

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
        ];

        $response = $this->actingAs($user)->postJson('/api/contragents', $data);

        dd($response->json());
        $response->assertStatus(Response::HTTP_CREATED);
    }
}
