<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'employee_id' => $this->faker->numberBetween(1, 10),
			'amount'      => 1000,
			'over_time'   => 0,
			'bonus'       => 0,
			'deduction'   => 0,
			'net_salary'  => 1000,
		];
	}
}
