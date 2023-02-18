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
			$table->string('salary')->nullable();
			$table->enum('rate', ['1', '2', '3', '4', '5'])->default('1');
			// department_id
			$table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
			// branch_id
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