<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_url' => $this->faker->domainName,
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company_name' => $this->faker->company,
            'email' => $this->faker->unique()->email,
            'password' => Hash::make(rand(0,999999)),
            'is_active' => rand(0,1)
        ];
    }
}
