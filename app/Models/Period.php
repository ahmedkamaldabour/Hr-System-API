<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
	use HasFactory;

	protected $fillable
		= [
			'period_name',
			'start_time',
			'end_time',
		];

	// period has many users
	public function users()
	{
		return $this->hasMany(User::class);
	}

}
