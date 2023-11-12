<?php

namespace App\Repositories\Product;

use App\Models\Product;
use LaravelEasyRepository\Implementations\Eloquent;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function find($id): Product
    {
        return $this->model->whereId($id)->first();
    }

    public function findOrFail($id)
    {
        return $this->model->whereId($id)->firstOrFail();
    }

    public function all()
    {
        $filters = ['id', 'name', 'slug', 'sku', 'short_description', 'description', 'price', 'stock', 'status', 'date_to_publish', 'qty', 'img', 'category_id', 'created_at', 'updated_at'];
        $sorts = ['id', 'name', 'slug', 'sku', 'short_description', 'description', 'price', 'stock', 'status', 'date_to_publish', 'qty', 'img', 'category_id', 'created_at', 'updated_at'];
        $fields = ['id', 'name', 'slug', 'sku', 'short_description', 'description', 'price', 'stock', 'status', 'date_to_publish', 'qty', 'img', 'category_id', 'created_at', 'updated_at'];

        $query = QueryBuilder::for(Product::class)
            ->allowedFields($fields)
            ->allowedIncludes(['category'])
            ->allowedFilters($filters)
            ->allowedSorts($sorts);

        $per_page = request()->per_page;
        $current_page = request()->page;
        if (! empty($per_page)) {
            $val = $query->paginate($per_page ?? 10, ['*'], 'page', $current_page ?? 1);
        } else {
            $val = $query->get();
        }

        return $val;
    }

    public function create($data): Product
    {
        return Product::create($data);
    }

    public function update($id, array $data): Product
    {
        $product = $this->model->whereId($id)->firstOrFail();
        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->whereId($id)->firstOrFail();
        $product->delete();

        return true;
    }

    public function destroy(array $data)
    {
        Product::whereIn('id', $data)->delete();

        return true;
    }
}
