<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
        $name = $this->faker->name;
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'img' => $fak->avatar($slug, '300x300'),
            'description' => $this->faker->realText(60),
        ];
    }
}
