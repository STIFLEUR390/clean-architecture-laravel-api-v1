<?php

namespace App\Http\Controllers\V1;

use App\Enums\OrderShippindStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Order\OrderServiceImplement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Commandes
 */
class OrderController extends Controller
{
    protected $orderService;

    /**
     * __construct
     *
     * @param  mixed  $addressService
     * @return void
     */
    public function __construct(OrderServiceImplement $orderService)
    {
        $this->orderService = $orderService;
        // $this->authorizeResource(Order::class, 'orders');
    }

    /**
     * Liste des commandes
     *
     * @response array{success: bool, message: string, data: array{data: OrderResource[]} ,}
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
            /**
             * Vous puvez inclure plusieur relation
             *
             * @var string include
             *
             * @example order_details,order_payment,billing,shipping
             */
            'include' => ['nullable', 'string'],
        ]);
        $orders = $this->orderService->all();

        return $this->resourceCollectionResponse(OrderResource::collection($orders), 'ok');
    }

    /**
     * Enregistrer une commande
     *
     * @response array{success: bool, message: string, data: OrderResource ,}
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create($request->all());

        return $this->resourceResponse(new OrderResource($order), 'ok');
    }

    /**
     * Récuperer une commande
     *
     * @param  string  $id L'identifiant de la commande
     *
     * @response array{success: bool, message: string, data: OrderResource ,}
     */
    public function show(Request $request, string $id)
    {
        $request->validate([
            /**
             * Vous puvez inclure plusieur relation
             *
             * @var string include
             *
             * @example order_details,order_payment,billing,shipping
             */
            'include' => ['nullable', 'string'],
        ]);
        $order = $this->orderService->findOrFail($id);

        return $this->resourceResponse(new OrderResource($order), 'ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Supprimer une commande
     *
     * @param  string  $id L'identifiant de la commande à supprimer
     *
     * @response array{success: bool, message: string}
     */
    public function destroy(string $id)
    {
        $this->orderService->delete($id);

        return $this->okResponse('ok');
    }

    /**
     * Supprimer plusieurs commandes
     *
     * @response array{success: bool, message: string}
     */
    public function multiDelete(Request $request)
    {
        $this->validate($request, [
            /**
             * Tableau des id des commandes à supprimer
             *
             * @var array{}
             *
             * @example {9a947661-d6c7-4033-9a91-7523d4633cfa, 9a947661-f0d3-4a52-8879-aebfcf9798e1}
             */
            'data' => ['required', 'array'],
        ]);

        $this->orderService->destroy($request->data);

        return $this->okResponse('ok');
    }

    /**
     * Mettre à jour le status d'une commande
     *
     * @response array{success: bool, message: string}
     */
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            // l'identifiant de la commande
            'id' => ['required', 'string', Rule::exists('orders', 'id')],
            // le statut de la commande
            'status' => ['required', Rule::enum(OrderShippindStatus::class)],
        ]);

        $this->orderService->updateOrderStatus($request->id, $request->status);

        return $this->okResponse('ok');
    }

    /**
     * Mettre à jour le status du paiement d'une commande
     *
     * @response array{success: bool, message: string}
     */
    public function updateOrderPaymentStatus(Request $request)
    {
        $request->validate([
            // l'identifiant du paiement
            'id' => ['required', 'string', Rule::exists('orders', 'id')],
            // le statut du paiement
            'status' => ['required', Rule::enum(OrderShippindStatus::class)],
        ]);

        $this->orderService->updateOrderPaymentStatus($request->id, $request->status);

        return $this->okResponse('ok');
    }

    /**
     * Récuperer le status du paiement d'une commande
     *
     * @param  mixed  $id l'identifiant du paiement d'une commande
     *
     * @response array{success: bool, message: string,data: array{ status:string}}
     */
    public function getOrderPaymentStatus(string $id)
    {
        $status = $this->orderService->getOrderPaymentStatus($id);

        return $this->okResponse('ok', ['status' => $status]);
    }

    /**
     * Generer la facture d'une commande
     *
     * @param  mixed  $id l'identifiant de la commande
     *
     * @response array{success: bool, message: string, data: array{invoice_url: string}}
     */
    public function generateInvoice(string $id): string
    {
        $invoice_url = $this->orderService->generateInvoice($id);

        return $this->okResponse('ok', ['invoice_url' => $invoice_url]);
    }

    /**
     * Verifier le paiement d'une commande
     *
     * @param  mixed  $id l'identifiant de la commande
     *
     * @response array{success: bool, message: string, data: OrderResource ,}
     */
    public function verifyPaiement(string $id)
    {
        $order = $this->orderService->verifyPaiement($id);

        return $this->resourceResponse(new OrderResource($order), 'ok');
    }

    /**
     * Annuler un paiement
     *
     * @param  mixed  $id transaction_id de la commande
     * @return string
     */
    public function cancelOrderPayment(string $id)
    {
        $this->orderService->cancelOrderPayment($id);

        return $this->okResponse('ok');
    }
}
