<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'first_last_name' => $this->faker->lastName(),
            'second_lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'code' => Str::random(4),
            'contract_type' => $this->faker->randomElement($array = array('Temporal', 'Indefinido', 'Proyecto')), // 'Temporal',
            'active' => $this->faker->randomElement($array = array(true, false)),
        ];
    }
}
