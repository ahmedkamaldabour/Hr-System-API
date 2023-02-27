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
		Schema::create('vacations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
			$table->date('start_date');
			$table->date('end_date');
			$table->enum('vacation_type', ['pending', 'approved', 'rejected'])->default('pending');
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
		Schema::dropIfExists('vacations');
	}
};
