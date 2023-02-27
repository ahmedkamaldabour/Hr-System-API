<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up():void
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->enum('role', ['owner', 'admin', 'user'])->default('user');
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('image')->nullable();
			$table->enum('rate', ['1', '2', '3', '4', '5'])->default('1');

			$table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('cascade');
			$table->foreignId('over_time_type_id')->nullable()->constrained('over_time_types')->onDelete('cascade');
			$table->foreignId('period_id')->nullable()->constrained('periods')->onDelete('cascade');
			$table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
			$table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('cascade');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down():void
	{
		Schema::dropIfExists('users');
	}
};
