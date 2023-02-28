<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	use HasFactory;

	protected $fillable
		= [
			'name',
			'description',
		];

	// position has many employees
	public function employees()
	{
		return $this->hasMany(User::class);
	}
}
