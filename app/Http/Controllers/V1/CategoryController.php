<?php

namespace App\Http\Controllers\V1;

use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @tags Catégories
 */
class CategoryController extends Controller
{
    use UploadFile;

    protected $categoryService;

    /**
     * __construct
     *
     * @param  mixed  $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        // $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Liste des catégories
     *
     * @response array{current_page:1,data: CategoryResource[]}
     *
     * @return void
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
            'include' => ['nullable', 'string', Rule::in(['products'])],
        ]);

        $categories = $this->categoryService->getAll();

        return CategoryResource::collection($categories);
    }

    /**
     * Ajouter une catégorie de produit
     *
     * @return void
     */
    public function store(StoreCategoryRequest $request)
    {
        /*
        if ($request->user()->cannot('create', Post::class)) {
            abort(403);
        }
        */

        $img = $request->img ? $this->uploadFile($request->img, 'cats') : null;
        $categoryDTO = new CategoryDTO($request->name, $img, $request->description);
        $category = $this->categoryService->create($categoryDTO);

        return new CategoryResource($category);
    }

    /**
     * Récuperer une catégorie
     *
     * @param  string  $id L'identifiant de la catégorie a afficher
     * @return void
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getById($id);

        return new CategoryResource($category);
    }

    /**
     * Mettre à jour une catégorie
     *
     * @param  string  $id L'identifiant de la catégorie a mettre à jour
     * @return void
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        /*
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }
        */
        $cat = Category::whereId($id)->firstOrFail();
        if (! empty($request->img)) {
            $img = $this->uploadFile($request->img, 'cats', $cat->img);
            $categoryDTO = new CategoryDTO($request->name, $img, $request->description);
        } else {
            $categoryDTO = new CategoryDTO($request->name, $cat->img, $request->description);
        }

        $category = $this->categoryService->update($categoryDTO, $id);

        return new CategoryResource($category);
    }

    /**
     * Supprimer une catégotie
     *
     * @param  string  $id L'identifiant de la catégorie a supprimer
     * @return void
     */
    public function destroy(string $id)
    {
        Category::whereId($id)->firstOrFail();
        $this->categoryService->delete($id);

        return response()->json(['message' => 'Categorie deleted']);
    }
}
