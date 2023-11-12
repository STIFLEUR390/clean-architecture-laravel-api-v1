<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Services\Address\AddressServiceImplement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    protected $addressService;

    /**
     * __construct
     *
     * @param  mixed  $addressService
     * @return void
     */
    public function __construct(AddressServiceImplement $addressService)
    {
        $this->addressService = $addressService;
        // $this->authorizeResource(Address::class, 'address');
    }

    /**
     * Liste des addresses
     *
     * @response array{success: bool, message: string, data: array{data: AddressResource[]} ,}
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
            'include' => ['nullable', 'string', Rule::in(['customer'])],
        ]);

        $address = $this->addressService->all();

        return $this->resourceCollectionResponse(AddressResource::collection($address), 'ok');
    }

    /**
     * Enregistrer une addresse.
     *
     * @response array{success: bool, message: string, data: AddressResource ,}
     */
    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->create($request->all());

        return $this->resourceResponse(new AddressResource($address), 'ok');
    }

    /**
     * Récuperer une addresse
     *
     * @param  string  $id L'identifiant de l'addresse a afficher
     *
     * @response array{success: bool, message: string, data: AddressResource ,}
     */
    public function show(string $id)
    {
        $address = $this->addressService->findOrFail($id);

        return $this->resourceResponse(new AddressResource($address), 'ok');
    }

    /**
     * Mettre à jour une addresse
     *
     * @param  string  $id L'identifiant de l'addresse à mettre a jour
     *
     * @response array{success: bool, message: string, data: AddressResource ,}
     */
    public function update(UpdateAddressRequest $request, string $id)
    {
        $address = $this->addressService->update($id, $request->all());

        return $this->resourceResponse(new AddressResource($address), 'ok');
    }

    /**
     * Supprimer une addresse
     *
     * @param  string  $id L'identifiant de l'addresse a supprimer
     *
     * @response array{success: bool, message: string}
     */
    public function destroy(string $id)
    {
        $this->addressService->delete($id);

        return $this->okResponse('ok');
    }

    /**
     * Supprimer plusieurs addresses
     *
     * @response array{success: bool, message: string}
     */
    public function multiDelete(Request $request)
    {
        $this->validate($request, [
            /**
             * Tableau des id  des addresses à supprimer
             *
             * @var array{}
             *
             * @example {9a947661-d6c7-4033-9a91-7523d4633cfa, 9a947661-f0d3-4a52-8879-aebfcf9798e1}
             */
            'data' => ['required', 'array'],
            // 'data.*' => ['required', Rule::exists('addresses', 'id')],
        ]);

        $this->addressService->destroy($request->data);

        return $this->okResponse('ok');
    }
}
