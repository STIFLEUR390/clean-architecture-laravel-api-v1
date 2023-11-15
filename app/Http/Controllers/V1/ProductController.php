<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductServiceImplement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Produits
 */
class ProductController extends Controller
{
    protected $productService;

    /**
     * __construct
     *
     * @param  mixed  $productService
     * @return void
     */
    public function __construct(ProductServiceImplement $productService)
    {
        $this->productService = $productService;
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Liste des produits.
     *
     * @response array{success: bool, message: string, data: array{data: ProductResource[]} ,}
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
            'include' => ['nullable', 'string', Rule::in(['category'])],
        ]);

        $products = $this->productService->all();

        // return ProductResource::collection($products);
        return $this->resourceCollectionResponse(ProductResource::collection($products), 'ok');
    }

    /**
     * Enregistrer un nouveau produit
     *
     * @response array{success: bool, message: string, data: ProductResource ,}
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->all());

        return $this->resourceResponse(new ProductResource($product), 'ok');
    }

    /**
     * Récuperer un produit
     *
     * @param  string  $id L'identifiant du produit a afficher
     *
     * @response array{success: bool, message: string, data: ProductResource ,}
     */
    public function show(string $id)
    {
        $product = $this->productService->findOrFail($id);

        return $this->resourceResponse(new ProductResource($product), 'ok');
    }

    /**
     * Mettre à jour un produit
     *
     * @param  string  $id L'identifiant du produit à mettre a jour
     *
     * @response array{success: bool, message: string, data: ProductResource ,}
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->update($id, $request->all());

        return $this->resourceResponse(new ProductResource($product), 'ok');
    }

    /**
     * Supprimer un produit
     *
     * @param  string  $id L'identifiant du produit a supprimer
     *
     * @response array{success: bool, message: string}
     */
    public function destroy(string $id)
    {
        $this->productService->delete($id);

        return $this->okResponse('ok');
    }

    /**
     * Supprimer plusieurs produits
     *
     * @response array{success: bool, message: string}
     */
    public function multiDelete(Request $request)
    {
        $this->validate($request, [
            /**
             * Tableau des id  des produits à supprimer
             *
             * @var array{}
             *
             * @example {9a947661-d6c7-4033-9a91-7523d4633cfa, 9a947661-f0d3-4a52-8879-aebfcf9798e1}
             */
            'data' => ['required', 'array'],
            'data.*' => ['required', Rule::exists('products', 'id')],
        ]);

        $this->productService->destroy($request->data);

        return $this->okResponse('ok');
    }
}
