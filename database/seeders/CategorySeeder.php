<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();

        Category::factory()->create(['name' => 'Televisions']);
        Category::factory()->create(['name' => 'Mobile phones']);
        Category::factory()->create(['name' => 'Laptops']);
        Category::factory()->create(['name' => 'Cameras']);
        Category::factory()->create(['name' => 'Mens Clothing']);
        Category::factory()->create(['name' => 'Womens Clothing']);
        Category::factory()->create(['name' => 'Jewelry']);
        Category::factory()->create(['name' => 'Watches']);
    }
}
