<?php

namespace Tests;

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
}
