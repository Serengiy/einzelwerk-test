<?php

namespace App\Http\Controllers;


use App\Http\Requests\API\ContragentStoreRequest;
use App\Http\Resources\ContragentResource;
use App\Models\Contagent;
use App\Services\Contractor\ContractorService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContragentController extends Controller
{
    public function __construct(
        private readonly ContractorService $contractorService,
    ) {}

    public function index(Request $request): Response
    {
        $paginate = $request->get('per_page', 15);
        $quert = Contagent::query();
        $quert->filter($request->all());

        return Inertia::render('Dashboard', [
            'contragents' => ContragentResource::collection($quert->paginate($paginate))
        ]);
    }

    public function store(ContragentStoreRequest $request)
    {

        try {
            $this->contractorService->store($request->getData());
            return redirect()->back();
        }catch (ConnectionException $e) {
            return redirect()->back()->withErrors([
                'message' => 'Connection error'
            ]);
        }catch (NotFoundHttpException $e) {
            return redirect()->back()->withErrors(['message' => 'Contragent not found in the resource']);
        }
    }
}
