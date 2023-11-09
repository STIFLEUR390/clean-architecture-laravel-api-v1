<?php

namespace App\Traits;

trait Search
{
    public function globalSearch($query, $model, $val, $operator = 'LIKE')
    {
        $item = $model::first();
        $attributes = array_keys($item->getOriginal());
        $queries = $query;
        foreach ($attributes as $key => $attribute) {
            $queries = $key == 0 ? $this->rechercheParCologne($queries, $attribute, $operator, $val) : $this->rechercheParColonTwo($queries, $attribute, $operator, $val);
        }

        return $queries;
    }

    public function rechercheParCologne($query, $nomColonne, $operator, $value)
    {
        switch ($operator) {
            case '=':
            case '<>':
            case '!=':
            case '<':
            case '>':
            case '>=':
            case '<=':
                $query->where($nomColonne, $operator, $value);
                break;
            case 'LIKE':
            case 'NOT LIKE':
                $value = '%'.$value.'%';
                $query->where($nomColonne, $operator, $value);
                break;
            case 'IN':
                $value = explode(',', $value);
                $query->whereIn($nomColonne, $value);
                break;
            case 'NOT IN':
                $value = explode(',', $value);
                $query->whereNotIn($nomColonne, $value);
                break;
            case 'BETWEEN':
                $value = explode(',', $value);
                $query->whereBetween($nomColonne, $value);
                break;
            case 'NOT BETWEEN':
                $value = explode(',', $value);
                $query->whereNotBetween($nomColonne, $value);
                break;
            case 'IS NULL':
                $query->whereNull($nomColonne);
                break;
            case 'IS NOT NULL':
                $query->whereNotNull($nomColonne);
                break;
            default:
                // Opérateur non pris en charge
                throw new \InvalidArgumentException('Opérateur de comparaison non pris en charge.');
        }

        return $query;
    }

    public function rechercheParColonTwo($query, $nomColonne, $operator, $value)
    {
        switch ($operator) {
            case '=':
            case '<>':
            case '!=':
            case '<':
            case '>':
            case '>=':
            case '<=':
                $query->orWhere($nomColonne, $operator, $value);
                break;
            case 'LIKE':
            case 'NOT LIKE':
                $value = '%'.$value.'%';
                $query->orWhere($nomColonne, $operator, $value);
                break;
            case 'IN':
                $value = explode(',', $value);
                $query->orWhereIn($nomColonne, $value);
                break;
            case 'NOT IN':
                $value = explode(',', $value);
                $query->orWhereNotIn($nomColonne, $value);
                break;
            case 'BETWEEN':
                $value = explode(',', $value);
                $query->orWhereBetween($nomColonne, $value);
                break;
            case 'NOT BETWEEN':
                $value = explode(',', $value);
                $query->orWhereNotBetween($nomColonne, $value);
                break;
            case 'IS NULL':
                $query->orWhereNull($nomColonne);
                break;
            case 'IS NOT NULL':
                $query->orWhereNotNull($nomColonne);
                break;
            default:
                // Opérateur non pris en charge
                throw new \InvalidArgumentException('Opérateur de comparaison non pris en charge.');
        }

        return $query;
    }
}
