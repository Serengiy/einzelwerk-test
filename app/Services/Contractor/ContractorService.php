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
        $fetchedData = $this->getContractorInformationByInn($data->inn);
        $contragent = new Contagent();
        $contragent->inn = $fetchedData->inn;
        $contragent->name = $fetchedData->name;
        $contragent->ogrn = $fetchedData->ogrn;
        $contragent->address = $fetchedData->address;
        $contragent->save();
        return $contragent;
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
