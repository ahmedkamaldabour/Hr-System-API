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
			$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
			$table->time('attendance_time');
			$table->time('leaving_time');
			$table->double('working_hours')->nullable();
			$table->double('overtime')->nullable()->default(0);
			$table->date('attendance_date');
			$table->string('attendance_status');
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
