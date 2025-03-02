<?php

namespace App\DTOs\Auth;

/**
 * @property string $email
 * @property string $password
 */
class LoginUserDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
