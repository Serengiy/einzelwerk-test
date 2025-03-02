<?php

namespace Tests;

use App\Models\Contagent;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }
    public function createUser():User
    {
        $user = new User();
        $user->name = fake()->name;
        $user->email = fake()->email;
        $user->password = Hash::make('password');
        $user->save();
        return $user;
    }

    public function createContractor(): Contagent
    {
        $contragent = new Contagent();
        $contragent->name = fake()->name;
        $contragent->address = fake()->address;
        $contragent->inn = '';
        $contragent->ogrn = (string) fake()->numberBetween(1000000000, 999999999);
        $contragent->save();
        return $contragent;
    }
}
