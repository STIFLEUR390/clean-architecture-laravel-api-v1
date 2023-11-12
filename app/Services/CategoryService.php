<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CategoryDTO $CategoryDTO)
    {
        return $this->categoryRepository->create($CategoryDTO->toArray());
    }

    public function update(CategoryDTO $CategoryDTO, $id)
    {
        return $this->categoryRepository->update($CategoryDTO->toArray(), $id);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function getById($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }
}
