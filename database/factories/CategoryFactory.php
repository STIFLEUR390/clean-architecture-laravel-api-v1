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
        $fak->addProvider(new \Bezhanov\Faker\Provider\Avatar($fak));
        $name = $this->faker->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'img' => $fak->avatar($name, '300x300'),
            'description' => $this->faker->realText(60),
        ];
    }
}
