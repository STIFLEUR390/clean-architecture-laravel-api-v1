<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fak = \Faker\Factory::create();
        \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($fak);

        $product_name = $fak->productName;
        $slug = Str::slug($product_name);
        $status = ['publish', 'scheduled', 'inactive'];
        $stat = $status[rand(0, count($status) - 1)];

        return [
            'name' => $product_name,
            'slug' => Str::slug($product_name),
            // 'sku' => $fak->sku($product_name),
            'short_description' => $this->faker->realText(60),
            'description' => $this->faker->realText(),
            'price' => rand(10, 100),
            'stock' => $this->faker->boolean(75) ? 1 : 0,
            'status' => $stat,
            'date_to_publish' => $stat == 'scheduled' ? Carbon::now()->addDays(rand(5, 25)) : null,
            'qty' => rand(35, 75),
            'img' => $fak->avatar($slug),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
