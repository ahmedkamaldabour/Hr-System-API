<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

		// make admin user
		//		\App\Models\User::factory()->create([
		//			'name'              => 'admin',
		//			'email'             => 'admin@admin.hr',
		//			'email_verified_at' => now(),
		//			'password'          => bcrypt('123123123'), // password
		//			'remember_token'    => Str::random(10),
		//			'role'              => 'owner',
		//			'phone'             => '123456789',
		//			'address'           => 'Test address',
		//			'image'             => 'default.png',
		//			'salary'            => '1000000',
		//			'rate'              => '5',
		//		]);

		// add 10 departments to the database form the factory class
		//		\App\Models\Department::factory(5)->create();
		// add 2 branches to the database form the factory class
		//		\App\Models\Branche::factory(2)->create();
		// add 10 users to the database form the factory class
		//				\App\Models\User::factory(8)->create();
	}
}
