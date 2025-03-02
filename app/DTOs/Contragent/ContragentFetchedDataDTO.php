<?php

namespace App\DTOs\Contragent;

/**
 * @property string $inn
 * @property string $name,
 * @property string $ogrn,
 * @property string $address,
 */
readonly class ContragentFetchedDataDTO
{
    public function __construct(
        public string $inn,
        public string $name,
        public string $ogrn,
        public string $address,
    ) {}
}
