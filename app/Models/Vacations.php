<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacations extends Model
{
	use HasFactory;

	protected $fillable
		= [
			'employee_id',
			'start_date',
			'end_date',
			'vacation_type',
		];

	// vacation belongs to one employee
	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

}
