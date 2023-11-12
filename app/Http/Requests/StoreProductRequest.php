<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'alpha_num'],
            'stock' => ['required', 'boolean'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
            'date_to_publish' => ['nullable', 'date', 'before:now'],
            'qty' => ['required', 'numeric'],
            // La taille maximun de l'image est de 15M
            'img' => ['required', File::image()->max(15 * 1024)],
            // L'identifiant de la catégorie auquel apartient le produit
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }
}
