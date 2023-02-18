<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition():array
	{
		return [
			'name'              => fake()->name(),
			'email'             => fake()->unique()->safeEmail(),
			'email_verified_at' => now(),
			'password'          => bcrypt('123456789'), // password
			'remember_token'    => Str::random(10),
			'role'              => 'user',
			'phone'             => fake()->phoneNumber(),
			'address'           => fake()->address(),
			'image'             => 'default.png',
			'salary'            => fake()->randomFloat(2, 1000, 10000),
			'rate'              => fake()->numberBetween(1, 5),
			'department_id'     => fake()->numberBetween(1, 5),
			'branch_id'         => fake()->numberBetween(1, 2),
		];
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 *
	 * @return $this
	 */
	public function unverified():static
	{
		return $this->state(fn(array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
