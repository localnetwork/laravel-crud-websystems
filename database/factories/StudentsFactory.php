<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Students>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first_name = $this->faker->word();
        $middle_name = $this->faker->word();
        $last_name = $this->faker->word();
        $age = $this->faker->numberBetween(18, 30);
        $province = $this->faker->state();
        $city = $this->faker->city();
        $barangay = $this->faker->streetName();
        $department = $this->faker->randomElement(['HM','IT','Education']);

        return [
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'age' => $age,
            'province' => $province,
            'city' => $city,
            'barangay' => $barangay,
            'department' => $department,

        ];
    }
}
