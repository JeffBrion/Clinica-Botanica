<?php

namespace Database\Factories;

use App\Models\Patients\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Patients\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $gender = fake()->randomElement(['M','F','O']);
        return [
            'name' => fake()->firstName($gender === 'M' ? 'male' : ($gender === 'F' ? 'female' : null)),
            'last_name' => fake()->lastName(),
            'gender' => $gender,
            'birth_date' => fake()->optional(0.8)->date('Y-m-d', '-18 years'),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'email' => fake()->optional(0.5)->safeEmail(),
            'address' => fake()->optional(0.6)->address(),
            'notes' => fake()->optional()->sentence(8),
        ];
    }
}
