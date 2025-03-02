<?php

namespace Tests\Feature\API\Contractor;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContractorCanBeListedTest extends TestCase
{
    public function test_contractors_can_be_listed(): void
    {
        $user = $this->createUser();
        $query = [
            'per_page' => 3,
            'page' => 2,
//            'address' => 'Ивановская обл'
        ];
        $response = $this->actingAs($user)->getJson('/api/contragents?' . http_build_query($query));

        $response->assertStatus(Response::HTTP_OK);
    }
}
