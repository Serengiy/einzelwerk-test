<?php

namespace App\DTOs\Contragent;

use App\Models\User;

/**
 * @property string $inn
 */
readonly class ContragentStoreDTO
{
    public function __construct(
        public string $inn,
    ) {}
}
