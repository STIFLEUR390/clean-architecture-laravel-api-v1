<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\Customer\CustomerServiceImplement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Clients
 */
class CustomerController extends Controller
{
    protected $customerService;

    /**
     * __construct
     *
     * @param  mixed  $customerService
     * @return void
     */
    public function __construct(CustomerServiceImplement $customerService)
    {
        $this->customerService = $customerService;
        // $this->authorizeResource(Customer::class, 'customer');
    }

    /**
     * Liste des clients
     *
     * @response array{success: bool, message: string, data: array{data: CustomerResource[]} ,}
     */
    public function index(Request $request)
    {
        $request->validate([
            /**
             * définie le nombre d'élement que vous voulez recuperer
             *
             * @var int per_page
             *
             * @example 10
             */
            'per_page' => ['nullable', 'integer'],
            /**
             * Récupere une page en particulier lors de la pagination
             *
             * @var int page
             *
             * @example 1
             */
            'page' => ['nullable', 'integer'],
            'include' => ['nullable', 'string', Rule::in(['addresses'])],
        ]);

        $customers = $this->customerService->all();

        return $this->resourceCollectionResponse(CustomerResource::collection($customers), 'ok');
    }

    /**
     * Enregistrer un client.
     *
     * @response array{success: bool, message: string, data: CustomerResource ,}
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = $this->customerService->create($request->all());

        return $this->resourceResponse(new CustomerResource($customer), 'ok');
    }

    /**
     * Récuperer un client
     *
     * @param  string  $id L'identifiant du client a afficher
     *
     * @response array{success: bool, message: string, data: CustomerResource ,}
     */
    public function show(string $id)
    {
        $customer = $this->customerService->findOrFail($id);

        return $this->resourceResponse(new CustomerResource($customer), 'ok');
    }

    /**
     * Mettre à jour un client
     *
     * @param  string  $id L'identifiant du client à mettre a jour
     *
     * @response array{success: bool, message: string, data: CustomerResource ,}
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $customer = $this->customerService->update($id, $request->all());

        return $this->resourceResponse(new CustomerResource($customer), 'ok');
    }

    /**
     * Supprimer un client
     *
     * @param  string  $id L'identifiant du client a supprimer
     *
     * @response array{success: bool, message: string}
     */
    public function destroy(string $id)
    {
        $this->customerService->delete($id);

        return $this->okResponse('ok');
    }

    /**
     * Supprimer plusieurs clients
     *
     * @response array{success: bool, message: string}
     */
    public function multiDelete(Request $request)
    {
        $this->validate($request, [
            /**
             * Tableau des id  des clients à supprimer
             *
             * @var array{}
             *
             * @example {9a947661-d6c7-4033-9a91-7523d4633cfa, 9a947661-f0d3-4a52-8879-aebfcf9798e1}
             */
            'data' => ['required', 'array'],
            // 'data.*' => ['required', Rule::exists('customers', 'id')],
        ]);

        $this->customerService->destroy($request->data);

        return $this->okResponse('ok');
    }
}
