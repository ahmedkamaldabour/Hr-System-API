<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();

		// \App\Models\User::factory()->create([
		//     'name' => 'Test User',
		//     'email' => 'test@example.com',
		// ]);

		\App\Models\Department::factory(5)->create();
		\App\Models\Branch::factory(2)->create();
		\App\Models\OvertimeType::factory(3)->create();
		\App\Models\Period::factory(3)->create();
		\App\Models\Position::factory(3)->create();
		\App\Models\User::factory(10)->create();
		\App\Models\Salary::factory(3)->create();
		\App\Models\Attendance::factory(3)->create();
		\App\Models\Vacation::factory(3)->create();

		//		make admin user
		\App\Models\User::factory()->create([
			'name'              => 'admin',
			'email'             => 'admin@admin.hr',
			'email_verified_at' => now(),
			'password'          => bcrypt('123123123'), // password
			'remember_token'    => Str::random(10),
			'role'              => 'owner',
			'phone'             => '123456789',
			'address'           => 'Test address',
			'image'             => 'default.png',
			'rate'              => '5',
		]);


	}
}
