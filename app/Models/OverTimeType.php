<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverTimeType extends Model
{
	use HasFactory;

	protected $fillable = ['type', 'hour_price'];

	// overtimetype has many users
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
