<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\API\ContragentStoreRequest;
use App\Http\Resources\ContragentResource;
use App\Models\Contagent;
use App\Models\User;
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

    /**
     * Get a list of contractors
     *
     * This endpoint retrieves a paginated list of contractors along with their associated users.
     *
     * @group Contractors
     *
     * @queryParam per_page integer The number of results per page. Defaults to 15. Example: 20
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "inn": "7707083893",
     *       "address": "123 Main St, Moscow",
     *       "name": "ООО Контрагент",
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "email_verified_at": "2024-03-01 12:00:00"
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://your-app.test/api/contractors?page=1",
     *     "last": "http://your-app.test/api/contractors?page=3",
     *     "prev": null,
     *     "next": "http://your-app.test/api/contractors?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 3,
     *     "path": "http://your-app.test/api/contractors",
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 45
     *   }
     * }
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $paginate = $request->get('per_page', 15);
        $query = Contagent::query()->with('user');
        $query->filter($request->all());
        return ContragentResource::collection($query->paginate($paginate));
    }

    /**
     * Create a new contractor
     *
     * This endpoint allows creating a new contractor by providing an INN, address, name, and a user ID.
     *
     * @group Contractors
     *
     * @bodyParam inn string required The INN (Taxpayer Identification Number) of the contractor. Example: "7707083893"
     * @bodyParam address string optional The address of the contractor. Example: "123 Main St, Moscow"
     * @bodyParam name string required The name of the contractor. Example: "ООО Контрагент"
     * @bodyParam user_id integer required The ID of the associated user. Must exist in the users table. Example: 1
     *
     * @response 201 {
     *   "id": 1,
     *   "inn": "7707083893",
     *   "address": "123 Main St, Moscow",
     *   "name": "ООО Контрагент",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "email_verified_at": "2024-03-01 12:00:00"
     *   }
     * }
     * @response 404 {
     *   "message": "User not found"
     * }
     * @response 503 {
     *   "message": "Service is temporarily unavailable, try again later"
     * }
     */
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

    /**
     * Attach a user to a contractor
     *
     * This endpoint allows associating a user with a contractor.
     *
     * @group Contractors
     *
     * @urlParam contagent required The ID of the contractor to attach the user to. Example: 1
     * @urlParam user required The ID of the user to associate with the contractor. Example: 2
     *
     * @response 200 {
     *   "id": 1,
     *   "inn": "7707083893",
     *   "address": "123 Main St, Moscow",
     *   "name": "ООО Контрагент",
     *   "user": {
     *     "id": 2,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "email_verified_at": "2024-03-01 12:00:00"
     *   }
     * }
     * @response 404 {
     *   "message": "Contractor or user not found"
     * }
     */
    public function attach(Contagent $contagent, User $user): ContragentResource
    {
        $contagent->user()->associate($user);
        return ContragentResource::make($contagent->load('user'));
    }
}
