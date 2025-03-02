<?php

namespace App\DTOs\Contragent;

use App\Models\User;

/**
 * @property string $inn
 * @property User $user
 */
readonly class ContragentStoreDTO
{
    public function __construct(
        public string $inn,
        public User $user,
    ) {}
}
