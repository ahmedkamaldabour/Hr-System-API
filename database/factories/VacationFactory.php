<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacation>
 */
class VacationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'employee_id'   => $this->faker->numberBetween(1, 10),
			'start_date'    => $this->faker->date(),
			'end_date'      => $this->faker->date(),
			'vacation_type' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
		];
	}
}
