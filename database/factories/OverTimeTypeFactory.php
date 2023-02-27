<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OverTimeType>
 */
class OverTimeTypeFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'type'       => $this->faker->word,
			'hour_price' => $this->faker->randomFloat(2, 0, 100),
		];
	}
}
