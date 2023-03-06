<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('salaries', function (Blueprint $table) {
			$table->id();
			$table->foreignId('employee_id')->constrained('users');
			$table->double('amount');
			$table->double('over_time')->nullable();
			$table->double('bonus')->nullable();
			$table->double('deduction')->nullable();
			$table->double('net_salary');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('salaries');
	}
};
