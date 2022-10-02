<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->firstName(),
            'first_name' => $this->faker->firstName(),
            'phone_number' => $this->faker->mobileNumber(),
            'birth_date' => $this->faker->dateTimeBetween(date("01/01/1900"), now()),
        ];
    }
}
