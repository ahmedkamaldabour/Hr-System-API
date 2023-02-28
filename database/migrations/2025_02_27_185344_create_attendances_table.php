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
		Schema::create('attendances', function (Blueprint $table) {
			$table->id();
			$table->foreignId('employee_id')->constrained('users');
			$table->time('attendance_time')->nullable();
			$table->time('leaving_time')->nullable();
			$table->double('working_hours')->nullable();
			$table->double('overtime')->nullable()->default(0);
			$table->date('attendance_date')->nullable();
			$table->enum('attendance_status', ['worked', 'present', 'absent'])->default('present');
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
		Schema::dropIfExists('attendances');
	}
};
