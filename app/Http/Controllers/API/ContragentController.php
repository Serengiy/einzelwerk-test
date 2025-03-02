<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\API\ContragentStoreRequest;
use App\Http\Resources\ContragentResource;
use App\Models\Contagent;
use App\Services\Contractor\ContractorService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContragentController extends APIController
{
    public function __construct(
        private readonly ContractorService $contractorService,
    )
    {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $paginate = $request->get('per_page', 15);
        $query = Contagent::query()->with('user');
        $query->filter($request->all());
        return ContragentResource::collection($query->paginate($paginate));
    }

    public function store(ContragentStoreRequest $request): JsonResponse|ContragentResource
    {
        try {
            $contragent = $this->contractorService->store($request->getData());
            return new ContragentResource($contragent->load('user'));
        }catch (ConnectionException $e) {
            return $this->respondWithWrapper([
                'message' => 'Service is temporary unavailable, try again later'
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }catch (NotFoundHttpException $e) {
            return $this->respondNotFound($e->getMessage());
        }
    }
}
