<?php

namespace App\Services\API;

use App\DTOs\Contragent\ContragentFetchedDataDTO;
use App\Interfaces\ContractorInformationFetcherInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DadataService implements ContractorInformationFetcherInterface
{
    private readonly string $token;
    private readonly string $timeout;
    private readonly string $url;
    protected string $v;
    public function __construct()
    {
        $this->token = config('dadata.token');
        $this->timeout = config('dadata.timeout');
        $this->url = config('dadata.suggestions_api') . '/' . config('dadata.version');
    }

    /**
     * @throws ConnectionException
     * @throws NotFoundHttpException
     */
    public function getOrganizationByInn(string $inn): ContragentFetchedDataDTO
    {
        $query = [
          'query' => $inn
        ];

        $response = $this->post('/rs/findById/party', $query);

        $firstMatchedOrganization = $response->json('suggestions')[0]['data'] ?? [];
        if(empty($firstMatchedOrganization)) {
            throw new NotFoundHttpException('No contractors found with this INN');
        }

        return new ContragentFetchedDataDTO(
            inn: $inn,
            name: $firstMatchedOrganization['name']['short_with_opf'] ?? '',
            ogrn: $firstMatchedOrganization['ogrn'] ?? '',
            address: $firstMatchedOrganization['address']['unrestricted_value'] ?? '',
        );
    }


    /**
     * @throws ConnectionException
     */
    private function post(string $uri, array $data): PromiseInterface|Response
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => sprintf('Token %s', $this->token),
        ];
        return Http::withHeaders($headers)->timeout($this->timeout)
            ->post($this->url . $uri, $data);
    }

}
