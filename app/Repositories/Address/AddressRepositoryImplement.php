<?php

namespace App\Repositories\Address;

use App\Models\Address;
use LaravelEasyRepository\Implementations\Eloquent;
use Spatie\ModelInfo\ModelInfo;
use Spatie\QueryBuilder\QueryBuilder;

class AddressRepositoryImplement extends Eloquent implements AddressRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function find($id): Address
    {
        return $this->model->whereId($id)->first();
    }

    public function findOrFail($id)
    {
        return $this->model->whereId($id)->firstOrFail();
    }

    public function all()
    {
        $modelInfo = ModelInfo::forModel(Address::class);
        $attributes = $modelInfo->attributes->pluck('name')->toArray();
        $relations = $modelInfo->relations->pluck('name')->toArray();
        $filters = $sorts = $fields = $attributes;
        // dd($relations, $attributes);

        $query = QueryBuilder::for(Address::class)
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

    public function create($data): Address
    {
        return Address::create($data);
    }

    public function update($id, array $data): Address
    {
        $address = $this->model->whereId($id)->firstOrFail();
        $address->update($data);

        return $address;
    }

    public function delete($id)
    {
        $address = $this->model->whereId($id)->firstOrFail();
        $address->delete();

        return true;
    }

    public function destroy(array $data)
    {
        Address::whereIn('id', $data)->delete();

        return true;
    }
}
