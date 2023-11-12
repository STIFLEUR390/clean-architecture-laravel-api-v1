<?php

namespace App\Repositories;

use App\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function create($data)
    {
        return Category::create($data);
    }

    public function update($data, $id)
    {
        $user = Category::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }

    public function getById($id)
    {
        return Category::findOrFail($id);
    }

    public function getAll()
    {
        $filters = ['id', 'name', 'slug', 'img', 'description', 'created_at', 'updated_at'];
        $sorts = ['id', 'name', 'slug', 'img', 'description', 'created_at', 'updated_at'];
        $fields = ['id', 'name', 'slug', 'img', 'description', 'created_at', 'updated_at'];

        $query = QueryBuilder::for(Category::class)
            ->allowedFields($fields)
            ->allowedIncludes(['products'])
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
}
