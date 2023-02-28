<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
	use HasFactory;

	protected $fillable
		= [
			'employee_id',
			'amount',
			'over_time',
			'bonus',
			'deduction',
			'net_salary',
		];

	// salary belongs to one employee
	public function user()
	{
		return $this->belongsTo(User::class, 'employee_id', 'id');
	}
}
