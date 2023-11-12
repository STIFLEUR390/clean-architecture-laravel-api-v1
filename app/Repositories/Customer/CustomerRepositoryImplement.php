<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use LaravelEasyRepository\Implementations\Eloquent;
use Spatie\ModelInfo\ModelInfo;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerRepositoryImplement extends Eloquent implements CustomerRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function find($id): Customer
    {
        return $this->model->whereId($id)->first();
    }

    public function findOrFail($id)
    {
        return $this->model->whereId($id)->firstOrFail();
    }

    public function all()
    {
        $modelInfo = ModelInfo::forModel(Customer::class);
        $attributes = $modelInfo->attributes->pluck('name')->toArray();
        $relations = $modelInfo->relations->pluck('name')->toArray();
        $filters = $sorts = $fields = $attributes;

        $query = QueryBuilder::for(Customer::class)
            ->allowedFields($fields)
            ->allowedIncludes($relations)
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

    public function create($data): Customer
    {
        return Customer::create($data);
    }

    public function update($id, array $data): Customer
    {
        $Customer = $this->model->whereId($id)->firstOrFail();
        $Customer->update($data);

        return $Customer;
    }

    public function delete($id)
    {
        $Customer = $this->model->whereId($id)->firstOrFail();
        $Customer->delete();

        return true;
    }

    public function destroy(array $data)
    {
        Customer::whereIn('id', $data)->delete();

        return true;
    }
}
