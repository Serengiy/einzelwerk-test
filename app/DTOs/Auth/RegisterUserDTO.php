<?php

namespace App\DTOs\Auth;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
