<?php

namespace App\Services\Contractor;

use App\DTOs\Contragent\ContragentFetchedDataDTO;
use App\DTOs\Contragent\ContragentStoreDTO;
use App\Interfaces\ContractorInformationFetcherInterface;
use App\Models\Contagent;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ContractorService
{
    public function __construct(
        private ContractorInformationFetcherInterface $fetcher,
    ) {}

    /**
     * @throws ConnectionException
     * @throws NotFoundHttpException
     */
    public function store(ContragentStoreDTO $data): Contagent
    {
        $user = $data->user;
        $fetchedData = $this->getContractorInformationByInn($data->inn);
        return $user->contragent()->create([
            'inn' => $fetchedData->inn,
            'name' => $fetchedData->name,
            'ogrn' => $fetchedData->ogrn,
            'address' => $fetchedData->address,
        ]);
    }

    /**
     * @throws ConnectionException
     * @throws NotFoundHttpException
     */
    public function getContractorInformationByInn(string $inn): ContragentFetchedDataDTO
    {
        return $this->fetcher->getOrganizationByInn($inn);
    }
}
