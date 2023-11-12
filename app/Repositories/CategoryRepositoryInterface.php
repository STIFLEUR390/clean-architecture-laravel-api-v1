<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    /**
     * Récupere une catégorie via son id
     *
     * @param  mixed  $id
     * @return void
     */
    public function getById($id);

    /**
     * permet de créer une nouvelle catégorie
     *
     * @param  mixed  $data
     * @return void
     */
    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getAll();
}
