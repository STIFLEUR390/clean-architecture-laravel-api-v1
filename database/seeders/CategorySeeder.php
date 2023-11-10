<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::truncate();
        // Category::truncate();

        Category::factory()->create(['name' => 'Televisions', 'slug' => Str::slug('Televisions')]);
        Category::factory()->create(['name' => 'Mobile phones', 'slug' => Str::slug('Mobile phones')]);
        Category::factory()->create(['name' => 'Laptops', 'slug' => Str::slug('Laptops')]);
        Category::factory()->create(['name' => 'Cameras', 'slug' => Str::slug('Cameras')]);
        Category::factory()->create(['name' => 'Mens Clothing', 'slug' => Str::slug('Mens Clothing')]);
        Category::factory()->create(['name' => 'Womens Clothing', 'slug' => Str::slug('Womens Clothing')]);
        Category::factory()->create(['name' => 'Jewelry', 'slug' => Str::slug('Jewelry')]);
        Category::factory()->create(['name' => 'Watches', 'slug' => Str::slug('Watches')]);
    }
}
