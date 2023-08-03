<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => $this->faker->unique()->numberBetween(1, 5000),
            "nome" => $this->faker->name(),
            "cpf" => '000.000.000-00',
            "celular" => $this->faker->phoneNumber(),
            "created_at" => $this->faker->dateTime('now')
        ];
    }
}
