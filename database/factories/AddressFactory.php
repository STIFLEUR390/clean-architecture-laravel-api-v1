<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if ($this->faker->boolean) {
            $name = $this->faker->firstNameFemale.' '.$this->faker->lastName;
            $civility = $this->faker->boolean ? 'Mme' : 'Mlle';
        } else {
            $civility = 'M.';
            $name = $this->faker->firstNameMale.' '.$this->faker->lastName;
        }

        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'civility' => $civility,
            'name' => $name,
            'country' => 'CM',
            'city' => $this->faker->city,
            'line1' => $this->faker->address,
            'line2' => $this->faker->boolean ? $this->faker->address : null,
            'postal_code' => $this->faker->boolean ? $this->faker->postcode : null,
            'state' => $this->faker->citySuffix,
            'personnal' => $this->faker->boolean,
        ];
    }
}
