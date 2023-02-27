<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'employee_id'       => $this->faker->numberBetween(1, 10),
			'attendance_time'   => $this->faker->time(),
			'leaving_time'      => $this->faker->time(),
			'working_hours'     => 8,
			'overtime'          => 0,
			'attendance_date'   => $this->faker->date(),
			'attendance_status' => 'present',
		];
	}
}
