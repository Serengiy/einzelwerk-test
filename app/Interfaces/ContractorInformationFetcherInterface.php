<?php

namespace App\Interfaces;

use App\DTOs\Contragent\ContragentFetchedDataDTO;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ContractorInformationFetcherInterface
{
    /**
     * @throws ConnectionException
     * @throws NotFoundHttpException
     */
    public function getOrganizationByInn(string $inn): ContragentFetchedDataDTO;
}
