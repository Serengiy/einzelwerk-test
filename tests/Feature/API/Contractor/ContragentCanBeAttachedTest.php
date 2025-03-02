<?php

namespace Tests\Feature\API\Contractor;

use Tests\TestCase;

class ContragentCanBeAttachedTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_contragent_can_be_attached(): void
    {
        $user = $this->createUser();
        $userToAttach = $this->createUser();
        $contragent = $this->createContractor();

        $response = $this->actingAs($user)->postJson("/api/contragents/$contragent->id/attach/$userToAttach->id");

        $response->assertStatus(200);
    }
}
